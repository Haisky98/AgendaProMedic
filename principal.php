<?php
$rolActual = strtolower(trim($_SESSION['rol'] ?? ''));

if ($rolActual === 'medico') {
    require_once __DIR__ . '/_system/report_citas.php';
} else {
    require_once __DIR__ . '/_system/dashboard.php';
}
?>
