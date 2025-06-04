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
    <title>Ajouter un symptôme</title>
    <link rel="stylesheet" href="/assets/css/style.css" />
    <link rel="stylesheet" href="/assets/css/form.css" />
</head>
<body>
    <div class="container">
        <h1>Ajouter un symptôme 🩺</h1>

        <form action="/pain/submit" method="post" class="form-box">

            <!-- Type de symptôme -->
            <label for="symptom_type">Quel est le symptôme ?</label>
            <select name="symptom_type" id="symptom_type" required>
                <option value="">-- Sélectionner --</option>
                <option value="ballonnements">Ballonnements</option>
                <option value="gaz">Gaz</option>
                <option value="brulure">Brûlure</option>
                <option value="crampe">Crampe</option>
                <option value="douleur sourde">Douleur diffuse</option>
                <option value="autre">Autre</option>
            </select>

            <!-- Localisation -->
            <label for="location">Où ressentez-vous le symptôme ?</label>
            <select name="location" id="location" required>
                <option value="">-- Sélectionner --</option>
                <option value="estomac">Estomac</option>
                <option value="gauche">Côté gauche</option>
                <option value="droite">Côté droit</option>
                <option value="diffus">Diffus (généralisé)</option>
            </select>

            <!-- Intensité -->
            <label for="severity">Quelle est l’intensité ?</label>
            <select name="severity" id="severity" required>
                <option value="">-- Sélectionner --</option>
                <option value="faible">Faible</option>
                <option value="moderee">Modérée</option>
                <option value="forte">Forte</option>
            </select>

            <button type="submit" class="btn btn-login">Valider</button>
        </form>

        <div style="margin-top: 1.5rem;">
            <a href="/dashboard" class="logout-link">← Retour au dashboard</a>
        </div>
    </div>
</body>
</html>
