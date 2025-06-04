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
        $this->painModel->create($_SESSION['user_id'], $_POST);
        header('Location: /dashboard');
        exit;
    }
}
