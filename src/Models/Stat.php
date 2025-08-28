<?php
namespace App\Models;

use PDO;

class Stat {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Génère un tableau de stats par jour pour affichage dans le tableau responsive
    public function getDailyStats($userId) {
        // 1. Douleurs/symptômes
        $pain = $this->pdo->prepare("SELECT pain_date AS date, MAX(severity) AS max_pain, GROUP_CONCAT(DISTINCT symptom_type) AS symptoms, AVG(stress_level) AS stress FROM pains WHERE user_id = ? GROUP BY pain_date");
        $pain->execute([$userId]);
        $painRows = $pain->fetchAll(PDO::FETCH_UNIQUE);


        // 2. Repas
        $meals = $this->pdo->prepare("SELECT m.id, m.meal_date AS date, m.meal_type FROM meals m WHERE user_id = ?");
        $meals->execute([$userId]);
        $mealRows = $meals->fetchAll(PDO::FETCH_ASSOC);

        // 2b. Aliments par type de repas et par date
        $foodsByDateType = [];
        foreach ($mealRows as $row) {
            $date = $row['date'];
            $type = $row['meal_type'];
            $mealId = $row['id'];
            $stmt = $this->pdo->prepare("SELECT f.name FROM meal_food mf JOIN foods f ON mf.food_id = f.id WHERE mf.meal_id = ?");
            $stmt->execute([$mealId]);
            $foods = $stmt->fetchAll(PDO::FETCH_COLUMN);
            if (!isset($foodsByDateType[$date])) {
                $foodsByDateType[$date] = [
                    'matin' => [], '10h' => [], 'midi' => [], 'gouter' => [], 'soir' => []
                ];
            }
            if (isset($foodsByDateType[$date][$type])) {
                $foodsByDateType[$date][$type] = array_merge($foodsByDateType[$date][$type], $foods);
            }
        }

        // 3. Selles
        $poop = $this->pdo->prepare("SELECT poop_date AS date, GROUP_CONCAT(DISTINCT trend, ' (', frequency, ')') AS poop FROM poop_logs WHERE user_id = ? GROUP BY poop_date");
        $poop->execute([$userId]);
        $poopRows = $poop->fetchAll(PDO::FETCH_UNIQUE);

        // 4. Sport
        $sport = $this->pdo->prepare("SELECT sport_date AS date, GROUP_CONCAT(DISTINCT sport_type, ' (', duration, ')') AS sport FROM sport_sessions WHERE user_id = ? GROUP BY sport_date");
        $sport->execute([$userId]);
        $sportRows = $sport->fetchAll(PDO::FETCH_UNIQUE);


        // Extraire les vraies dates des repas
        $mealDates = [];
        foreach ($mealRows as $row) {
            $mealDates[] = $row['date'];
        }

        // Fusionner toutes les dates (uniquement les vraies dates)
        $allDates = array_unique(array_merge(
            array_keys($painRows),
            $mealDates,
            array_keys($poopRows),
            array_keys($sportRows)
        ));
        sort($allDates);

        $result = [];
        foreach ($allDates as $date) {
            $foods_matin = isset($foodsByDateType[$date]['matin']) ? implode(', ', array_unique($foodsByDateType[$date]['matin'])) : '';
            $foods_10h = isset($foodsByDateType[$date]['10h']) ? implode(', ', array_unique($foodsByDateType[$date]['10h'])) : '';
            $foods_midi = isset($foodsByDateType[$date]['midi']) ? implode(', ', array_unique($foodsByDateType[$date]['midi'])) : '';
            $foods_gouter = isset($foodsByDateType[$date]['gouter']) ? implode(', ', array_unique($foodsByDateType[$date]['gouter'])) : '';
            $foods_soir = isset($foodsByDateType[$date]['soir']) ? implode(', ', array_unique($foodsByDateType[$date]['soir'])) : '';
            $result[] = [
                'date' => $date,
                'max_pain' => isset($painRows[$date]['max_pain']) ? $painRows[$date]['max_pain'] : '',
                'symptoms' => isset($painRows[$date]['symptoms']) ? $painRows[$date]['symptoms'] : '',
                'foods_matin' => $foods_matin,
                'foods_10h' => $foods_10h,
                'foods_midi' => $foods_midi,
                'foods_gouter' => $foods_gouter,
                'foods_soir' => $foods_soir,
                'poop' => isset($poopRows[$date]['poop']) ? $poopRows[$date]['poop'] : '',
                'sport' => isset($sportRows[$date]['sport']) ? $sportRows[$date]['sport'] : '',
                'stress' => isset($painRows[$date]['stress']) ? round($painRows[$date]['stress'],1) : ''
            ];
        }
        return $result;
    }

    // Moyenne du nombre de caca par jour pour un utilisateur
    public function getAveragePoopPerDay($userId) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) / COUNT(DISTINCT DATE(created_at)) as avg_per_day
            FROM poop_logs
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }

    // Répartition des formes de caca (pour camembert)
    public function getPoopFormDistribution($userId) {
        $stmt = $this->pdo->prepare("
            SELECT form, COUNT(*) as count
            FROM poop_logs
            WHERE user_id = ?
            GROUP BY form
        ");
        $stmt->execute([$userId]);
        $raw = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        // Mappe les valeurs numériques vers les labels
        $labels = [
            1 => 'Dur',
            2 => 'Normal',
            3 => 'Mou',
            4 => 'Liquide'
        ];
        $result = [];
        foreach ($labels as $num => $label) {
            $result[$label] = isset($raw[$num]) ? (int)$raw[$num] : 0;
        }
        return $result;
    }

        // Pourcentage de chaque symptôme (camembert)
    public function getPainSymptomPercentages($userId) {
        $stmt = $this->pdo->prepare("
            SELECT symptom_type, COUNT(*) as count
            FROM pains
            WHERE user_id = ?
            GROUP BY symptom_type
        ");
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $total = array_sum($rows);
        $percentages = [];
        foreach ($rows as $type => $count) {
            $percentages[$type] = $total > 0 ? round(($count / $total) * 100, 1) : 0;
        }
        return $percentages;
    }

    // Pourcentage de repas où l'utilisateur avait faim
    public function getHungryMealPercentage($userId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM meals WHERE user_id = ?");
        $stmt->execute([$userId]);
        $total = $stmt->fetchColumn();

        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM meals WHERE user_id = ? AND hunger_before = 1");
        $stmt->execute([$userId]);
        $hungry = $stmt->fetchColumn();

        return $total > 0 ? round(($hungry / $total) * 100, 1) : 0;
    }

    public function getLimitedByBellyPercentage($userId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM sport_sessions WHERE user_id = ?");
        $stmt->execute([$userId]);
        $total = $stmt->fetchColumn();

        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM sport_sessions WHERE user_id = ? AND limited_by_belly = 1");
        $stmt->execute([$userId]);
        $limited = $stmt->fetchColumn();

        return $total > 0 ? round(($limited / $total) * 100, 1) : 0;
    }


    // Répartition des localisations
    public function getPainLocationDistribution($userId) {
        $stmt = $this->pdo->prepare("
            SELECT location, COUNT(*) as count
            FROM pains
            WHERE user_id = ?
            GROUP BY location
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    // Répartition des intensités
    public function getPainSeverityDistribution($userId) {
        $labels = [
            1 => 'Très faible',
            2 => 'Faible',
            3 => 'Modérée',
            4 => 'Forte',
            5 => 'Très forte'
        ];
        $stmt = $this->pdo->prepare("
            SELECT severity, COUNT(*) as count
            FROM pains
            WHERE user_id = ?
            GROUP BY severity
        ");
        $stmt->execute([$userId]);
        $raw = $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
        $result = [];
        foreach ($labels as $num => $label) {
            $result[$label] = isset($raw[$num]) ? (int)$raw[$num] : 0;
        }
        return $result;
    }

    // Répartition des niveaux de stress
    public function getPainStressDistribution($userId) {
    $labels = [
        1 => 'Très faible',
        2 => 'Faible',
        3 => 'Modéré',
        4 => 'Élevé',
        5 => 'Très élevé'
    ];
    $stmt = $this->pdo->prepare("
        SELECT stress_level, COUNT(*) as count
        FROM pains
        WHERE user_id = ?
        GROUP BY stress_level
    ");
    $stmt->execute([$userId]);
    $raw = $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    $result = [];
    foreach ($labels as $num => $label) {
        $result[$label] = isset($raw[$num]) ? (int)$raw[$num] : 0;
    }
    return $result;
    }

}




