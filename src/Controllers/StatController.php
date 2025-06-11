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

        $avgPoop = $this->statModel->getAveragePoopPerDay($userId);
        $poopForms = $this->statModel->getPoopFormDistribution($userId);
        $painPercent = $this->statModel->getPainSymptomPercentages($userId);
        $hungryMealPercent = $this->statModel->getHungryMealPercentage($userId);
        $painLocation = $this->statModel->getPainLocationDistribution($userId);
        $painSeverity = $this->statModel->getPainSeverityDistribution($userId);
        $painStress = $this->statModel->getPainStressDistribution($userId);
        $limitedByBellyPercent = $this->statModel->getLimitedByBellyPercentage($userId);

        require __DIR__ . '/../Views/statsView.php';
    } 
}