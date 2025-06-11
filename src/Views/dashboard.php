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

    <a href="/logout" class="logout-link">Se déconnecter</a>

    <h1>Bienvenue sur ton tableau de bord, <?php echo htmlspecialchars($user['username']); ?> !</h1>

    <div class="main-content">
        <div class="menu">
            <button class="poop-btn" onclick="location.href='/poop'">Ajouter une selle</button>
            <button class="pain-btn" onclick="location.href='/pain'">Questionnaire douleur</button>
            <button class="meal-btn" onclick="location.href='/meal'">Repas</button>
            <button class="sport-btn" onclick="location.href='/sport'">Sport</button>
            <button class="stat-btn" onclick="location.href='/stats'">📊 Statistiques</button>
        </div>
    </div>

</body>
</html>
