<?php
namespace App\Models;

use PDO;

class Stat {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
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




