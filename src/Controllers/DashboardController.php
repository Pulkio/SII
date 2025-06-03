<?php
namespace App\Controllers;

use App\Models\User;

class DashboardController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function show() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);

        if (!$user) {
            session_destroy();
            header('Location: /login');
            exit;
        }

        // Maintenant, on passe $user à la vue
        require_once __DIR__ . '/../Views/dashboard.php';
    }
}
