<?php
namespace App\Controllers;

use App\Models\User;

class AuthController {
    private $userModel;

    // On injecte la connexion PDO dans le constructeur, et on instancie User
    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    // Méthode pour afficher la page d'accueil (login/register)
    public function showHome() {
        // Ici tu pourrais inclure la vue (ex: require 'path/to/home.php')
        require_once __DIR__ . '/../Views/home.php';
    }

    // Traitement du formulaire d'inscription
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validation basique 
            if (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password) >= 6) {
                $created = $this->userModel->create($email, $password);
                if ($created) {
                    // Création OK, redirection vers login ou auto-login
                    header('Location: /login?registered=1');
                    exit;
                } else {
                    $error = "Cet email est déjà utilisé.";
                }
            } else {
                $error = "Email invalide ou mot de passe trop court (6 caractères minimum).";
            }
        }

        // Si erreur, on affiche la vue avec un message d’erreur
        require_once __DIR__ . '/../Views/register.php';
    }

    // Traitement du formulaire de connexion
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $userId = $this->userModel->authenticate($email, $password);
            if ($userId !== false) {
                // Auth OK, on stocke l'id en session
                session_start();
                $_SESSION['user_id'] = $userId;

                // Redirection vers la page privée, tableau de bord, etc.
                header('Location: /dashboard');
                exit;
            } else {
                $error = "Email ou mot de passe incorrect.";
            }
        }

        require_once __DIR__ . '/../Views/login.php';
    }

    public function logout() {
    // Vérifie si une session n'est pas déjà démarrée avant de la démarrer
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Détruit toutes les données de session (déconnexion)
        session_destroy();

        // Redirige vers la page d'accueil (home.php généralement à la racine '/')
        header('Location: /');
        exit; // Termine l'exécution du script immédiatement après la redirection
    }
}
