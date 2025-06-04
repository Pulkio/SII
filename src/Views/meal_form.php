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
    <title>Ajouter un repas</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/form.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter un repas 🍽️</h1>

        <form action="/meal/submit" method="POST" class="form-box">
            <!-- Faim -->
            <label for="hunger_before">Aviez-vous faim ?</label>
            <select name="hunger_before" id="hunger_before" required>
                <option value="">-- Sélectionner --</option>
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>

            <!-- Taille du repas -->
            <label for="meal_size">Taille du repas :</label>
            <select name="meal_size" id="meal_size" required>
                <option value="">-- Sélectionner --</option>
                <option value="petit">Petit</option>
                <option value="normal">Normal</option>
                <option value="gros">Gros</option>
            </select>

            <!-- Aliments -->
            <label for="food_input">Que contenait le repas ?</label>
            <input list="food_options" type="text" id="food_input" placeholder="Ex. Riz, poulet..." />
            <datalist id="food_options">
                <?php foreach ($foods as $food): ?>
                    <option value="<?= htmlspecialchars($food) ?>">
                <?php endforeach; ?>
            </datalist>
            <button type="button" onclick="addFood()">Ajouter</button>

            <!-- Liste visible -->
            <ul id="food_list"></ul>

            <!-- Champ caché avec la liste finale -->
            <input type="hidden" name="selected_foods" id="selected_foods" />

            <button type="submit" class="btn btn-login">Valider</button>
        </form>

        <div style="margin-top: 1.5rem;">
            <a href="/dashboard" class="logout-link">← Retour au dashboard</a>
        </div>
    </div>

    <script>
        let selectedFoods = [];

        function addFood() {
            const input = document.getElementById('food_input');
            const food = input.value.trim();

            if (food && !selectedFoods.includes(food)) {
                selectedFoods.push(food);
                updateList();
                input.value = '';
            }
        }

        function updateList() {
            const list = document.getElementById('food_list');
            const hidden = document.getElementById('selected_foods');
            list.innerHTML = '';

            selectedFoods.forEach(food => {
                const li = document.createElement('li');
                li.textContent = food;
                list.appendChild(li);
            });

            hidden.value = selectedFoods.join(',');
        }
    </script>
</body>
</html>
