<?php
// db.php : établit la connexion PDO à la base colon_tracker en local

$host = 'localhost';          // Serveur MySQL local
$dbname = 'colon_tracker';    // Nom de la base de données
$user = 'root';               // Utilisateur MySQL local
$pass = '14162124';           // Mot de passe MySQL local 

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
