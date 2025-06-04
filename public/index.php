<?php
// ==========================
// INITIALISATION
// ==========================

// Démarre la session PHP pour gérer l'utilisateur connecté
session_start();

// Chargement automatique des classes (via Composer)
require_once __DIR__ . '/../vendor/autoload.php';

// Connexion à la base de données ($pdo)
require_once __DIR__ . '/../config/db.php';

// ==========================
// IMPORTS DE CONTRÔLEURS
// ==========================

use App\Controllers\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\PoopController;
use App\Controllers\PainController;
use App\Controllers\MealController; 
use App\Controllers\SportController;

// ==========================
// INSTANCIATION
// ==========================

// Création d'une instance du routeur
$router = new Router();

// Instanciation des contrôleurs avec injection du PDO
$authController = new AuthController($pdo);
$dashboardController = new DashboardController($pdo);
$poopController = new PoopController($pdo);
$painController = new PainController($pdo);
$mealController = new MealController($pdo); 
$sportController = new SportController($pdo);

// ==========================
// ROUTES PUBLIQUES
// ==========================

// Page d'accueil
$router->get('/', function() {
    require __DIR__ . '/../src/Views/home.php';
});

// ==========================
// ROUTES AUTHENTIFICATION
// ==========================

// Connexion
$router->get('/login', fn() => $authController->login());
$router->post('/login', fn() => $authController->login());

// Inscription
$router->get('/register', fn() => $authController->register());
$router->post('/register', fn() => $authController->register());

// Déconnexion
$router->get('/logout', fn() => $authController->logout());

// ==========================
// ROUTES UTILISATEUR CONNECTÉ
// ==========================

// Dashboard (page principale après connexion)
$router->get('/dashboard', fn() => $dashboardController->show());

// === MODULE POOP ===
$router->get('/poop', [$poopController, 'showForm']);
$router->post('/poop/submit', [$poopController, 'submitForm']);

// === MODULE PAIN ===
$router->get('/pain', [$painController, 'showForm']);
$router->post('/pain/submit', [$painController, 'submitForm']);

// === MODULE MEAL (REPAS) ===
// Formulaire d'ajout de repas
$router->get('/meal', [$mealController, 'showForm']);
$router->post('/meal/submit', [$mealController, 'submit']);

// Routes sport
$router->get('/sport', [$sportController, 'showForm']);
$router->post('/sport/submit', [$sportController, 'submit']);


// Route pour les statistiques
$router->get('/stats', function() {
    require __DIR__ . '/../src/Views/stats.php';
});

// ==========================
// DÉCLENCHEMENT DU ROUTEUR
// ==========================

// Analyse l'URL actuelle et exécute la fonction associée
$router->handle($_SERVER['REQUEST_URI']);
