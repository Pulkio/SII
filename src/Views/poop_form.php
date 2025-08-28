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
            <!-- Date de la tendance -->
            <label for="poop_date">Date :</label>
            <input type="date" id="poop_date" name="poop_date" value="<?php echo date('Y-m-d'); ?>" required>

            <!-- Tendance -->
            <label for="trend">Tendance :</label>
            <select id="trend" name="trend" required>
                <option value="">Choisissez une tendance</option>
                <option value="constipé">Plutôt constipé</option>
                <option value="normal">Plutôt normal</option>
                <option value="diarrhé">Plutôt diarrhé</option>
            </select>

            <!-- Fréquence -->
            <label for="frequency">Fréquence :</label>
            <select id="frequency" name="frequency" required>
                <option value="">Choisissez la fréquence</option>
                <option value="0-1">0 à 1 fois</option>
                <option value="2-4">2 à 4 fois</option>
                <option value=">4">Plus de 4 fois</option>
            </select>

            <!-- Ancien champ forme (optionnel, à garder si utile) -->
            <label for="form">Forme (optionnel) :</label>
            <select id="form" name="form">
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
