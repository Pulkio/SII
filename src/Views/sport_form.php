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
    <title>Ajouter une séance de sport</title>
    <link rel="stylesheet" href="/assets/css/style.css" />
    <link rel="stylesheet" href="/assets/css/form.css" />
</head>
<body>
    <div class="container">
        <h1>Ajouter une séance de sport 🏋️</h1>

        <form action="/sport/submit" method="POST" class="form-box">


            <!-- Type de sport -->
            <label for="sport_type">Type de sport</label>
            <select name="sport_type" id="sport_type" required>
                <option value="">-- Sélectionner --</option>
                <option value="course">Course à pied</option>
                <option value="musculation">Musculation</option>
                <option value="natation">Natation</option>
                <option value="cyclisme">Cyclisme</option>
                <option value="randonnee">Randonnée</option>
                <option value="autre">Autre</option>
            </select>

            <!-- Durée de l'effort -->
            <label for="duration">Durée de l'effort</label>
            <select name="duration" id="duration" required>
                <option value="">-- Sélectionner --</option>
                <option value="<15">Moins de 15 min</option>
                <option value="15-30">15 à 30 min</option>
                <option value="30-45">30 à 45 min</option>
                <option value="45-60">45 à 60 min</option>
                <option value=">60">Plus d'une heure</option>
            </select>

            <!-- Intensité -->
            <label for="intensity">Intensité ressentie (RPE simplifié)</label>
            <select name="intensity" id="intensity" required>
                <option value="">-- Sélectionner --</option>
                <option value="1">1 - Très facile</option>
                <option value="2">2 - Facile</option>
                <option value="3">3 - Moyen</option>
                <option value="4">4 - Difficile</option>
                <option value="5">5 - Épuisant</option>
            </select>

            <!-- Douleur -->
            <label for="pain">Avez-vous ressenti une douleur pendant l’effort ?</label>
            <select name="pain" id="pain" required>
                <option value="">-- Sélectionner --</option>
                <option value="non">Non</option>
                <option value="faible">Oui - Faible</option>
                <option value="moderee">Oui - Modérée</option>
                <option value="forte">Oui - Forte</option>
            </select>

            <!-- Limitation par le ventre -->
            <label for="limited_by_belly">Le ventre vous a-t-il limité pendant la séance ?</label>
            <select name="limited_by_belly" id="limited_by_belly" required>
                <option value="">-- Sélectionner --</option>
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>

            <button type="submit" class="btn btn-login">Valider</button>
        </form>

        <div style="margin-top: 1.5rem;">
            <a href="/dashboard" class="logout-link">← Retour au dashboard</a>
        </div>
    </div>
</body>
</html>
