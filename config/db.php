<?php
// db.php : établit la connexion PDO à la base colon_tracker en local

$host = 'localhost'; // Hostinger : généralement 'localhost' pour MySQL
$dbname = 'u214587418_sii'; // Nom de la base Hostinger
$user = 'u214587418_sii_user'; // Utilisateur Hostinger
$pass = 'Colon_sii8+'; // Mot de passe Hostinger

$options = [
    // Active la gestion des erreurs via des exceptions PDO
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // Récupère les résultats sous forme de tableaux associatifs
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // Désactive l'émulation des requêtes préparées (plus sécurisé)
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    // Création de l'objet PDO qui se connecte à la base avec charset utf8mb4
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, $options);
} catch (PDOException $e) {
    // En cas d'erreur, on stoppe le script et on affiche le message
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
