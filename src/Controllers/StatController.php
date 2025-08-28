<?php
namespace App\Controllers;

use App\Models\Stat;

class StatController {
    private $statModel;

    public function __construct($pdo) {
        $this->statModel = new Stat($pdo);
    }

    public function show() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    $userId = $_SESSION['user_id'];
    $dailyStats = $this->statModel->getDailyStats($userId);
    require __DIR__ . '/../Views/statsView.php';
    } 
}