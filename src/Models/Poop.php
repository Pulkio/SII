<?php
namespace App\Models;

class Poop {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($userId, $form) {
        $stmt = $this->pdo->prepare("INSERT INTO poop_logs (user_id, form, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$userId, $form]);
    }
}
