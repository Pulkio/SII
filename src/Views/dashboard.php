<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css" />
</head>
<body>


    <h1>Bienvenue sur votre dashboard</h1>
    
    <div class="menu">
        <button class="poop-btn" onclick="location.href='/poop'">Ajouter une selle</button>
        <button class="pain-btn" onclick="location.href='/pain'">Questionnaire douleur</button>
        <button class="meal-btn" onclick="location.href='/meal'">Repas</button>
        <button class="sport-btn" onclick="location.href='/sport'">Sport</button>
    </div>

    <a href="/logout" class="logout-link">Se déconnecter</a>


</body>
</html>
