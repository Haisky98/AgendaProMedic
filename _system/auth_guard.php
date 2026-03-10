<?php
require_once __DIR__ . '/../_class/session_helper.php';
agp_require_auth_page('../login.php');

$rolActual = agp_current_role();
$vistaActual = strtolower(basename($_SERVER['SCRIPT_NAME'] ?? ''));

if ($rolActual === 'medico') {
    $vistasPermitidas = ['report_citas.php'];
    if (!in_array($vistaActual, $vistasPermitidas, true)) {
        agp_require_role_page(['admin']);
    }
}
?>
