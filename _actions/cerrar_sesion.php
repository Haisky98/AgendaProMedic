<?php
require_once __DIR__ . '/../_class/session_helper.php';

header('Content-Type: application/json; charset=utf-8');
agp_logout_user();

echo json_encode([
    'success' => true
]);
?>
