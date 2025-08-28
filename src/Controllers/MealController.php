<?php
namespace App\Controllers;

use App\Models\Meal;
use PDO;

class MealController {
    private $mealModel;

    // On crée une instance du modèle Meal avec la connexion PDO
    public function __construct(PDO $pdo) {
        $this->mealModel = new Meal($pdo);
    }

    // Affiche le formulaire
    public function showForm() {
        // Récupérer la liste des aliments en base
        $foods = $this->mealModel->getAllFoods();
        require_once __DIR__ . '/../Views/meal_form.php';
    }

    // Traite la soumission du formulaire
    public function submit() {
        session_start();

        // L'utilisateur doit être connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }


        // Récupération des données du formulaire
        $userId = $_SESSION['user_id'];
        $hungerBefore = $_POST['hunger_before'] ?? null;
        $mealSize = $_POST['meal_size'] ?? null;
        $foods = explode(',', $_POST['selected_foods'] ?? '');
        $mealDate = $_POST['meal_date'] ?? date('Y-m-d');
        $mealType = $_POST['meal_type'] ?? 'midi';

        // Vérification simple
        if ($hungerBefore !== null && $mealSize && !empty($foods) && $mealDate && $mealType) {
            $this->mealModel->create($userId, $hungerBefore, $mealSize, $foods, $mealDate, $mealType);
        }

        // Redirection
        header('Location: /dashboard');
        exit;
    }
}
