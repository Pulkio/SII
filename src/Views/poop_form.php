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
                <option value="">-- Choisissez --</option>
                <option value="1">1 - Boules dures (type 1)</option>
                <option value="2">2 - Sausage grumeleux</option>
                <option value="3">3 - Saucisse craquelée</option>
                <option value="4">4 - Lisse, en forme de saucisse</option>
                <option value="5">5 - Petits morceaux mous</option>
                <option value="6">6 - Bouillie</option>
                <option value="7">7 - Liquide (diarrhée)</option>
            </select>

            <button type="submit" class="btn btn-login">Valider</button>
        </form>

        <a href="/dashboard" class="logout-link">← Retour au dashboard</a>
    </div>
</body>
</html>
