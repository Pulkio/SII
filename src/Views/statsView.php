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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .graph-section {
            margin: 40px 0 40px 0;
            text-align: center;
        }
        .graph-section h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>📊 Vos statistiques</h1>
    <br>
    <p>Moyenne de selles par jour : <strong><?= round($avgPoop, 2) ?></strong></p>
    <br>

    <p>Pourcentage de repas où vous aviez faim : <strong><?= $hungryMealPercent ?>%</strong></p>
    <br>
    <p>Pourcentage de séances limitées par le ventre : <strong><?= $limitedByBellyPercent ?>%</strong></p>
    <div class="graph-section">
        <h2>Répartition des formes de selles</h2>
        <canvas id="poopPie" width="300" height="300"></canvas>
    </div>

    <div class="graph-section">
        <h2>Répartition des symptômes</h2>
        <canvas id="painPie" width="300" height="300"></canvas>
    </div>

    <div class="graph-section">
        <h2>Répartition des localisations des symptômes</h2>
        <canvas id="painLocationPie" width="300" height="300"></canvas>
    </div>

    <div class="graph-section">
        <h2>Répartition des intensités de douleur</h2>
        <canvas id="painSeverityPie" width="300" height="300"></canvas>
    </div>

    <div class="graph-section">
        <h2>Répartition des niveaux de stress</h2>
        <canvas id="painStressPie" width="300" height="300"></canvas>
    </div>

    <a href="/dashboard">← Retour au dashboard</a>
</div>
<script>
    // Camembert pour la répartition des formes de caca
    const poopData = <?= json_encode($poopForms) ?>;
    new Chart(document.getElementById('poopPie'), {
        type: 'pie',
        data: {
            labels: Object.keys(poopData),
            datasets: [{
                data: Object.values(poopData),
                backgroundColor: ['#f39c12', '#27ae60', '#2980b9', '#e74c3c']
            }]
        }
    });

    // Camembert pour la répartition des symptômes de pain
    const painData = <?= json_encode($painPercent) ?>;
    new Chart(document.getElementById('painPie'), {
        type: 'pie',
        data: {
            labels: Object.keys(painData),
            datasets: [{
                data: Object.values(painData),
                backgroundColor: ['#e74c3c', '#f1c40f', '#2ecc71', '#9b59b6', '#34495e', '#95a5a6']
            }]
        }
    });

    // Localisation
    const painLocationData = <?= json_encode($painLocation) ?>;
    new Chart(document.getElementById('painLocationPie'), {
        type: 'pie',
        data: {
            labels: Object.keys(painLocationData),
            datasets: [{
                data: Object.values(painLocationData),
                backgroundColor: ['#f39c12', '#27ae60', '#2980b9', '#e74c3c']
            }]
        }
    });

    // Intensité
    const painSeverityData = <?= json_encode($painSeverity) ?>;
    new Chart(document.getElementById('painSeverityPie'), {
        type: 'pie',
        data: {
            labels: Object.keys(painSeverityData),
            datasets: [{
                data: Object.values(painSeverityData),
                backgroundColor: ['#f1c40f', '#e67e22', '#e74c3c', '#8e44ad', '#2ecc71']
            }]
        }
    });

    // Stress
    const painStressData = <?= json_encode($painStress) ?>;
    new Chart(document.getElementById('painStressPie'), {
        type: 'pie',
        data: {
            labels: Object.keys(painStressData),
            datasets: [{
                data: Object.values(painStressData),
                backgroundColor: ['#3498db', '#1abc9c', '#9b59b6', '#e67e22', '#e74c3c']
            }]
        }
    });
</script>
</body>
</html>