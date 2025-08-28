<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) { die('Non autorisé'); }

require_once __DIR__ . '/../src/Models/Stat.php';
use App\Models\Stat;
$statModel = new Stat($pdo);
$dailyStats = $statModel->getDailyStats($userId);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$headers = [
    'Date', 'Douleur (max)', 'Symptômes',
    'Aliments matin', 'Aliments 10h', 'Aliments midi', 'Aliments goûter', 'Aliments soir',
    'Selles', 'Sport', 'Stress'
];
$sheet->fromArray($headers, null, 'A1');

$rowNum = 2;
foreach ($dailyStats as $row) {
    $sheet->fromArray([
        $row['date'],
        $row['max_pain'],
        $row['symptoms'],
        $row['foods_matin'],
        $row['foods_10h'],
        $row['foods_midi'],
        $row['foods_gouter'],
        $row['foods_soir'],
        $row['poop'],
        $row['sport'],
        $row['stress']
    ], null, 'A' . $rowNum++);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="suivi_journalier.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
