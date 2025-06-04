<?php
namespace App\Controllers;

use App\Models\Sport;
use PDO;

class SportController {
    private $model;

    public function __construct(PDO $pdo) {
        $this->model = new Sport($pdo);
    }

    public function showForm() {
        require_once __DIR__ . '/../Views/sport_form.php';
    }

    public function submit() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $duration = $_POST['duration'] ?? null;
        $intensity = $_POST['intensity'] ?? null;
        $pain = $_POST['pain'] ?? null;
        $limited = $_POST['limited_by_belly'] ?? null;

        if ($duration && $intensity && $pain !== null && $limited !== null) {
            $this->model->create($userId, $duration, $intensity, $pain, $limited);
        }

        header('Location: /dashboard');
        exit;
    }
}
