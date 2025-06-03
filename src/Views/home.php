<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    
    <!-- Titre de l'onglet du navigateur -->
    <title>Bienvenue</title>

    <!-- Assure que le site est bien affiché sur mobile avec zoom désactivé -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Lien vers ton fichier CSS personnalisé (placé dans /public/assets/css/style.css) -->
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- Lien vers une police moderne depuis Google Fonts (optionnel mais esthétique) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>

    <!-- Conteneur principal centré à l'écran -->
    <div class="container">

        <!-- Boîte avec fond blanc, bord arrondi et ombre -->
        <div class="box">

            <!-- Titre principal -->
            <h1>Bienvenue 👋</h1>

            <!-- Petit texte d'accueil -->
            <p>Connecte-toi ou crée un compte pour commencer.</p>

            <!-- Groupe de boutons -->
            <div class="button-group">

                <!-- Bouton pour accéder à la page de connexion -->
                <a href="/login" class="btn btn-login">Se connecter</a>

                <!-- Bouton pour accéder à la page d'inscription -->
                <a href="/register" class="btn btn-register">Créer un compte</a>
            </div>
        </div>
    </div>

</body>
</html>
