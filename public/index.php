<?php
session_start();

// Composer autoload (si tu en utilises un)
require_once __DIR__ . '/../vendor/autoload.php';

// Config DB
require_once __DIR__ . '/../config/db.php';



use App\Controllers\Router;
use App\Controllers\AuthController;
use App\Models\User;
use App\Controllers\DashboardController;

$router = new Router();

// Crée instance AuthController avec $pdo
$authController = new AuthController($pdo);

$dashboardController = new DashboardController($pdo);

// Déclare les routes GET
$router->get('/', function() {
    require __DIR__ . '/../src/Views/home.php';
});
$router->get('/login', function() use ($authController) {
    $authController->login();
});
$router->get('/register', function() use ($authController) {
    $authController->register();
});

// Routes POST
$router->post('/login', function() use ($authController) {
    $authController->login();
});
$router->post('/register', function() use ($authController) {
    $authController->register();
});


$router->get('/dashboard', function() use ($dashboardController) {
    $dashboardController->show();
});

// Déclare la route GET pour déconnexion qui appelle la méthode logout
$router->get('/logout', function() use ($authController) {
    $authController->logout();
});
 
// Gérer la requête
$router->handle($_SERVER['REQUEST_URI']);
