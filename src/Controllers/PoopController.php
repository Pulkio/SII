<?php
namespace App\Controllers;

use App\Models\Poop;

class PoopController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function showForm() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        require_once __DIR__ . '/../Views/poop_form.php';
    }

    public function submitForm() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // Utilise le $pdo injecté
        $poop = new Poop($this->pdo);
        $poop->create($_SESSION['user_id'], $_POST['form']);

        header('Location: /dashboard');
        exit;
    }
}
