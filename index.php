<?php

require_once '../src/IntervalCycler.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$cycler = new IntervalCycler();

if ($method === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'process') {
        $row = $_POST['row'] ?? '';
        if (empty($row)) {
            echo json_encode(['error' => 'No pitch data provided']);
            exit;
        }

        $pitches = array_map('intval', explode(' ', $row));
        $result = $cycler->process($pitches);
        echo json_encode(['success' => true, 'data' => $result]);
        exit;
    }

    if ($action === 'random') {
        $randomRow = $cycler->generateRandomPitches();
        echo json_encode(['success' => true, 'data' => $randomRow]);
        exit;
    }
}

echo json_encode(['error' => 'Invalid request']);
