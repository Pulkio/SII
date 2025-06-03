<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inscription - Colon Tracker</title>
    
    <!-- Style global commun à tout le site -->
    <link rel="stylesheet" href="/assets/css/style.css" />
    <!-- Styles spécifiques à la page register -->
    <link rel="stylesheet" href="/assets/css/register.css" />
</head>
<body>
    <div class="container">
        <div class="box">
            <h1>Créer un compte</h1>
            <form action="/register" method="POST" class="form-register">
                <input type="email" name="email" placeholder="Email" required autocomplete="email" />
                <input type="password" name="password" placeholder="Mot de passe" required autocomplete="new-password" />
                <input type="password" name="password_confirm" placeholder="Confirmer le mot de passe" required autocomplete="new-password" />
                <button type="submit" class="btn btn-register">S'inscrire</button>
            </form>

            <p>Déjà inscrit ? <a href="/login">Se connecter</a></p>
        </div>
    </div>
</body>
</html>
