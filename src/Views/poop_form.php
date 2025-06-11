<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Ajouter un caca</title>
    <link rel="stylesheet" href="/assets/css/style.css" />
    <link rel="stylesheet" href="/assets/css/form.css" />
</head>
<body>
    <div class="container">
        <h1>Ajouter un caca 💩</h1>

        <form action="/poop/submit" method="POST" class="form-box">
            <select id="form" name="form" required>
                <option value="">Choisissez une option</option>
                <option value="1">Dur</option>
                <option value="2">Normal</option>
                <option value="3">Mou</option>
                <option value="4">Liquide</option>
            </select>

            <button type="submit" class="btn btn-login">Valider</button>
        </form>

        <a href="/dashboard" class="logout-link">← Retour au dashboard</a>
    </div>
</body>
</html>
