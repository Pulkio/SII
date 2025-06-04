<?php
namespace App\Controllers;

// Import du modèle User pour gérer les données utilisateur
use App\Models\User;

class DashboardController {
    private $userModel;

    /**
     * Constructeur du contrôleur.
     * Initialise une instance du modèle User avec la connexion PDO.
     * 
     * @param \PDO $pdo Connexion à la base de données
     */
    public function __construct($pdo) {
        // Création d'une instance du modèle User avec la connexion PDO
        $this->userModel = new User($pdo);
    }

    /**
     * Affiche la page du dashboard.
     * Vérifie si l'utilisateur est connecté et valide.
     * Si non connecté, redirige vers la page de connexion.
     */
    public function show() {
        // Démarre la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifie si l'utilisateur est connecté (id en session)
        if (!isset($_SESSION['user_id'])) {
            // Redirection vers la page login si non connecté
            header('Location: /login');
            exit;
        }

        // Récupère l'ID utilisateur stocké en session
        $userId = $_SESSION['user_id'];

        // Recherche l'utilisateur en base via le modèle User
        $user = $this->userModel->findById($userId);

        // Si l'utilisateur n'existe pas en base, détruit la session et redirige vers login
        if (!$user) {
            session_destroy();
            header('Location: /login');
            exit;
        }

        // L'utilisateur est authentifié et valide,
        // on inclut la vue dashboard en lui passant l'objet $user
        require_once __DIR__ . '/../Views/dashboard.php';
    }
}
