<?php
namespace App\Models;

class User {
    private $pdo;  // Instance PDO utilisée pour interagir avec la base

    // Constructeur, on injecte la connexion PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Crée un nouvel utilisateur dans la base.
     * @param string $username Pseudo de l'utilisateur
     * @param string $email Email de l'utilisateur
     * @param string $password Mot de passe en clair
     * @return bool true si création OK, false si email déjà utilisé
     */
    public function create($username, $email, $password) {
        // 1. Vérifier si l'email existe déjà
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            // Email déjà présent, on refuse la création
            return false;
        }

        // 2. Hasher le mot de passe pour sécuriser le stockage
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // 3. Insérer le nouvel utilisateur dans la base
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $email, $hash]);
    }

    /**
     * Authentifie un utilisateur via email + mot de passe.
     * @param string $email Email envoyé par le formulaire
     * @param string $password Mot de passe envoyé par le formulaire
     * @return mixed L'id utilisateur si authentification OK, sinon false
     */
    public function authenticate($email, $password) {
        // 1. Récupérer l'utilisateur par email
        $stmt = $this->pdo->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // 2. Vérifier que l'utilisateur existe et que le mot de passe correspond
        if ($user && password_verify($password, $user['password'])) {
            // Authentification réussie, on retourne l'id utilisateur
            return $user['id'];
        }

        // Authentification échouée
        return false;
    }

    /**
     * Trouve un utilisateur par son ID.
     * @param int $id ID de l'utilisateur
     * @return array|false Les informations de l'utilisateur si trouvé, sinon false
     */
    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT id, username, email FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
