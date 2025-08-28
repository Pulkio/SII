<?php
namespace App\Controllers;

use App\Models\Pain;

class PainController {
    private $painModel;

    public function __construct($pdo) {
        $this->painModel = new Pain($pdo);
    }

    public function showForm() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        require __DIR__ . '/../Views/pain_form.php'; // Ton formulaire renommé
    }

    public function submitForm() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        require __DIR__ . '/../../config/db.php';
        $userId = $_SESSION['user_id'];
        $painDate = $_POST['pain_date'] ?? date('Y-m-d');
        $symptoms = $_POST['symptom_type'] ?? [];
        $location = $_POST['location'] ?? null;
        $severity = $_POST['severity'] ?? null;
        $stress = $_POST['stress_level'] ?? null;
        if (!empty($symptoms) && $location && $severity && $stress) {
            foreach ($symptoms as $symptom) {
                $this->painModel->create($userId, [
                    'symptom_type' => $symptom,
                    'location' => $location,
                    'severity' => $severity,
                    'stress_level' => $stress,
                    'pain_date' => $painDate
                ]);
            }
        }
        header('Location: /dashboard');
        exit;
    }
}
