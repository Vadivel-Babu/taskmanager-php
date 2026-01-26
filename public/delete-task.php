<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . "/../core/Task.php";


header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    echo json_encode(['status'=>'error', 'message'=>'Invalid CSRF token']);
    exit;
}

$id = $_POST['id'] ?? '';

if ($id === '') {
    echo json_encode(['status' => 'error', 'message' => 'ID required']);
    exit;
}

$task = new Task();

if ($task->deleteTask($id)) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Delete failed']);
}