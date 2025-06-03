<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Connexion - Colon Tracker</title>
    
    <!-- Style global commun à tout le site -->
    <link rel="stylesheet" href="/assets/css/style.css" />
    <!-- Styles spécifiques à la page login -->
    <link rel="stylesheet" href="/assets/css/login.css" />
</head>
<body>
    <div class="container">
        <div class="box">
            <h1>Connexion</h1>
            <form action="/login" method="POST" class="form-login">
                <input type="email" name="email" placeholder="Email" required autocomplete="username" />
                <input type="password" name="password" placeholder="Mot de passe" required autocomplete="current-password" />
                <button type="submit" class="btn btn-login">Se connecter</button>
            </form>

            <p>Pas encore inscrit ? <a href="/register">Créer un compte</a></p>
        </div>
    </div>
</body>
</html>
