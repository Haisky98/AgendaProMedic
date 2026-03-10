<?php
require_once __DIR__ . '/../_class/session_helper.php';
agp_require_auth_json();

$rolActual = agp_current_role();
$accionActual = strtolower(basename($_SERVER['SCRIPT_NAME'] ?? ''));

if ($rolActual === 'medico') {
    $accionesPermitidas = [
        'get_tabla_citas.php',
        'actualizar_contrasena.php'
    ];

    if (!in_array($accionActual, $accionesPermitidas, true)) {
        agp_require_role_json(['admin']);
    }
}
?>
