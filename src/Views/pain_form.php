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
            <!-- Date du symptôme -->
            <label for="pain_date">Date :</label>
            <input type="date" name="pain_date" id="pain_date" value="<?php echo date('Y-m-d'); ?>" required>

            <!-- Type de symptôme (cases à cocher) -->
            <label>Quels sont les symptômes ?</label>
            <div class="checkbox-group" style="display: flex; flex-wrap: wrap; gap: 1rem;">
                <label style="display: flex; align-items: center;"><input type="checkbox" name="symptom_type[]" value="ballonnements" style="margin-right: 6px;">Ballonnements</label>
                <label style="display: flex; align-items: center;"><input type="checkbox" name="symptom_type[]" value="gaz" style="margin-right: 6px;">Gaz</label>
                <label style="display: flex; align-items: center;"><input type="checkbox" name="symptom_type[]" value="brulure" style="margin-right: 6px;">Brûlure</label>
                <label style="display: flex; align-items: center;"><input type="checkbox" name="symptom_type[]" value="crampe" style="margin-right: 6px;">Crampe</label>
                <label style="display: flex; align-items: center;"><input type="checkbox" name="symptom_type[]" value="douleur sourde" style="margin-right: 6px;">Douleur diffuse</label>
                <label style="display: flex; align-items: center;"><input type="checkbox" name="symptom_type[]" value="autre" style="margin-right: 6px;">Autre</label>
            </div>

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
            <label for="severity">Quelle est l’intensité de la douleur ?</label>
            <select name="severity" id="severity" required>
                <option value="">-- Sélectionner --</option>
                <option value="1">Niveau 1 - Très faible</option>
                <option value="2">Niveau 2 - Faible</option>
                <option value="3">Niveau 3 - Modérée</option>
                <option value="4">Niveau 4 - Forte</option>
                <option value="5">Niveau 5 - Très forte</option>
            </select>

            <!-- Niveau de stress -->
            <label for="stress_level">Quel est votre niveau de stress ?</label>
            <select name="stress_level" id="stress_level" required>
                <option value="">-- Sélectionner --</option>
                <option value="1">Niveau 1 - Très faible</option>
                <option value="2">Niveau 2 - Faible</option>
                <option value="3">Niveau 3 - Modéré</option>
                <option value="4">Niveau 4 - Élevé</option>
                <option value="5">Niveau 5 - Très élevé</option>
            </select>

            <button type="submit" class="btn btn-login">Valider</button>
        </form>

        <div style="margin-top: 1.5rem;">
            <a href="/dashboard" class="logout-link">← Retour au dashboard</a>
        </div>
    </div>
</body>
</html>
