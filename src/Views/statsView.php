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
<div class="container wide-container">

        <h1>� Tableau de suivi journalier</h1>
        <div style="text-align:center;">
            <a href="/export_xlsx.php" class="btn btn-login" style="margin-bottom:1rem;">Exporter en Excel (.xlsx)</a>
        </div>
        <div style="overflow-x:auto; max-width: 98vw; padding: 2rem 0; min-height: 600px;">
        <table id="stats-table" class="responsive-table">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">Date</th>
                    <th>Douleur (intensité max)</th>
                    <th>Symptômes</th>
                    <th>Aliments matin</th>
                    <th>Aliments 10h</th>
                    <th>Aliments midi</th>
                    <th>Aliments goûter</th>
                    <th>Aliments soir</th>
                    <th>Selles</th>
                    <th>Sport</th>
                    <th>Stress</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($dailyStats as $row): ?>
                <tr>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime($row['date']))) ?></td>
                    <td><?= htmlspecialchars($row['max_pain']) ?></td>
                    <td><?= htmlspecialchars($row['symptoms']) ?></td>
                    <td><?= htmlspecialchars($row['foods_matin']) ?></td>
                    <td><?= htmlspecialchars($row['foods_10h']) ?></td>
                    <td><?= htmlspecialchars($row['foods_midi']) ?></td>
                    <td><?= htmlspecialchars($row['foods_gouter']) ?></td>
                    <td><?= htmlspecialchars($row['foods_soir']) ?></td>
                    <td><?= htmlspecialchars($row['poop']) ?></td>
                    <td><?= htmlspecialchars($row['sport']) ?></td>
                    <td><?= htmlspecialchars($row['stress']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <div style="margin-top:1.5rem;">
                <a href="/dashboard">← Retour au dashboard</a>
        </div>
</div>
<style>
.responsive-table {
    width: 1800px;
    min-width: 1200px;
    border-collapse: collapse;
    font-size: 1.15em;
    background: white;
    margin: 0;
}
.responsive-table th, .responsive-table td {
    border: 1px solid #ddd;
    padding: 12px 10px;
    text-align: center;
}
.responsive-table th {
    background-color: #f2f2f2;
    cursor: pointer;
    font-size: 1.1em;
}
@media (max-width: 1200px) {
    .responsive-table, .responsive-table thead, .responsive-table tbody, .responsive-table th, .responsive-table td, .responsive-table tr {
        display: block;
    }
    .responsive-table tr { margin-bottom: 15px; }
    .responsive-table td { text-align: right; padding-left: 50%; position: relative; }
    .responsive-table td:before {
        position: absolute;
        left: 10px;
        top: 8px;
        white-space: nowrap;
        font-weight: bold;
        content: attr(data-label);
    }
}
    .wide-container {
        max-width: 98vw;
        width: 98vw;
        margin: 0 auto;
        padding: 2rem 0;
    }
</style>
<script>
// Exporter le tableau en Excel
function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    filename = filename ? filename + '.xls' : 'export_excel.xls';
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['\ufeff', tableHTML], { type: dataType });
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        downloadLink.download = filename;
        downloadLink.click();
    }
    document.body.removeChild(downloadLink);
}
// Tri du tableau par colonne (0 = date, 1 = intensité douleur)
function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("stats-table");
    switching = true;
    dir = "desc";
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount ++;
        } else {
            if (switchcount == 0 && dir == "desc") {
                dir = "asc";
                switching = true;
            }
        }
    }
}
</script>
</body>
</html>