<?php
namespace App\Models;

use PDO;

class Sport {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function create($userId, $duration, $intensity, $pain, $limited, $sport_type) {
        $stmt = $this->pdo->prepare("
            INSERT INTO sport_sessions (user_id, duration, intensity, pain, limited_by_belly, sport_type)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$userId, $duration, $intensity, $pain, $limited, $sport_type]);
    }
}
