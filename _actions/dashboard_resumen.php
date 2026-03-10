<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_dashboard_dal.php';

header('Content-Type: application/json; charset=utf-8');

$dashboard = new dashboard_dal();
$resumen = $dashboard->get_resumen_hoy();
$topMedicos = $dashboard->get_top_medicos_hoy(6);

echo json_encode([
    'success' => true,
    'resumen' => $resumen,
    'top_medicos' => $topMedicos
], JSON_UNESCAPED_UNICODE);
?>
