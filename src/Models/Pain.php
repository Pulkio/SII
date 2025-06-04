<?php
namespace App\Models;

class Pain {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($userId, $data) {
        $stmt = $this->pdo->prepare("INSERT INTO pains (user_id, symptom_type, location, severity) 
                                     VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $userId,
            $data['symptom_type'],
            $data['location'],
            $data['severity']
        ]);
    }

    public function getAllByUser($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM pains WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
