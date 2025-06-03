<?php
namespace App\Controllers;

class Router {
    private $routes = [];

    // Ajoute une route GET
    public function get(string $path, callable $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    // Ajoute une route POST
    public function post(string $path, callable $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    // Gère la requête
    public function handle(string $uri) {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($uri, PHP_URL_PATH);

        // Redirige la racine vers /login (optionnel)
        if ($path === '/') {
            header('Location: /login');
            exit;
        }

        if (isset($this->routes[$method][$path])) {
            // Appelle la fonction associée à la route
            call_user_func($this->routes[$method][$path]);
        } else {
            http_response_code(404);
            echo "404 - Page non trouvée";
        }
    }
}
