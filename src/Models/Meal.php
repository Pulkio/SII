<?php
namespace App\Models;

use PDO;

class Meal {
    private $pdo;

    // Constructeur : reçoit un objet PDO (connexion à la base)
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Fonction pour enregistrer un repas
    public function create($userId, $hungerBefore, $mealSize, $foods, $mealDate, $mealType) {
        // 1. Insertion du repas dans la table meals (ajout date et type)
        $stmt = $this->pdo->prepare("INSERT INTO meals (user_id, hunger_before, meal_size, meal_date, meal_type) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $hungerBefore, $mealSize, $mealDate, $mealType]);
        $mealId = $this->pdo->lastInsertId(); // Récupère l'ID du repas créé

        // 2. Pour chaque aliment, l’ajouter à la table foods s’il n’existe pas, puis le lier au repas
        foreach ($foods as $foodName) {
            $foodName = trim($foodName);
            if (!$foodName) continue;

            // Vérifie si l'aliment existe
            $stmt = $this->pdo->prepare("SELECT id FROM foods WHERE name = ?");
            $stmt->execute([$foodName]);
            $food = $stmt->fetch();

            if ($food) {
                $foodId = $food['id']; // Existe déjà
            } else {
                // Ajout dans la table foods
                $stmt = $this->pdo->prepare("INSERT INTO foods (name) VALUES (?)");
                $stmt->execute([$foodName]);
                $foodId = $this->pdo->lastInsertId(); // Nouvel ID
            }

            // Lier aliment au repas
            $stmt = $this->pdo->prepare("INSERT INTO meal_food (meal_id, food_id) VALUES (?, ?)");
            $stmt->execute([$mealId, $foodId]);
        }

        return $mealId;
    }

    public function getAllFoods() {
        $stmt = $this->pdo->query("SELECT name FROM foods ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

}
