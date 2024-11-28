<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\IntervalCycler;
use Jenssegers\Blade\Blade;

$cycler = new IntervalCycler();
$error = null;
$results = null;
$randomRowDisplay = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'process') {
        $row = $_POST['row'] ?? '';
        if (!empty($row)) {
            $pitches = array_map('intval', explode(' ', $row));
            $results = $cycler->process($pitches);
        } else {
            $error = "Please enter pitch data.";
        }
    }

    if ($action === 'random') {
        $randomRow = $cycler->generateRandomPitches();
        $results = $cycler->process($randomRow);
        $randomRowDisplay = implode(' ', $randomRow);
    }
}

// Blade setup
$blade = new Blade(__DIR__ . '/../resources/views', __DIR__ . '/../cache');

// Render the template
echo $blade->render('interval-cycler', [
    'error' => $error,
    'results' => $results,
    'randomRowDisplay' => $randomRowDisplay,
]);
