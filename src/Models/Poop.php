<?php
namespace App\Models;

class Poop {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($userId, $poopDate, $trend, $frequency, $form = null) {
        $stmt = $this->pdo->prepare("INSERT INTO poop_logs (user_id, poop_date, trend, frequency, form, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$userId, $poopDate, $trend, $frequency, $form]);
    }
}
