<?php
require_once __DIR__ . '/../_class/session_helper.php';
agp_require_auth_json();

$rolActual = agp_current_role();
$traza = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
$archivoInvocador = '';

foreach ($traza as $frame) {
    if (empty($frame['file'])) {
        continue;
    }

    $candidato = basename((string)$frame['file']);
    if ($candidato === basename(__FILE__)) {
        continue;
    }

    $archivoInvocador = $candidato;
    break;
}

$accionActual = strtolower($archivoInvocador !== '' ? $archivoInvocador : basename($_SERVER['SCRIPT_NAME'] ?? ''));

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
