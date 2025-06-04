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
    <meta charset="UTF-8">
    <title>Statistiques</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>📊 Vos statistiques</h1>
        <p>Graphiques à venir ici !</p>
        <a href="/dashboard">← Retour au dashboard</a>
    </div>
</body>
</html>
