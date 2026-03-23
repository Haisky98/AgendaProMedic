<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_usuarios_dal.php';
require_once __DIR__ . '/../_class/validation_helper.php';

header('Content-Type: application/json; charset=utf-8');

$usuario = $_SESSION['usuario'] ?? '';
$actual = $_POST['actual'] ?? '';
$nueva = $_POST['nueva'] ?? '';
$confirmar = $_POST['confirmar'] ?? '';

if ($usuario === '' || $actual === '' || $nueva === '' || $confirmar === '') {
    echo json_encode([
        'status' => '0',
        'mensaje' => 'Todos los campos son obligatorios.'
    ]);
    exit;
}

$validActual = agp_validar_longitud_texto($actual, 'contraseña actual', 1, 72, true);
if (!$validActual[0]) {
    echo json_encode([
        'status' => '0',
        'mensaje' => $validActual[2]
    ]);
    exit;
}

$validNueva = agp_validar_password_basico($nueva, 6, 72);
if (!$validNueva[0]) {
    echo json_encode([
        'status' => '0',
        'mensaje' => $validNueva[2]
    ]);
    exit;
}

$dal = new class_usuario_dal();
$resultado = $dal->actualizar_contrasena($usuario, $actual, $nueva, $confirmar);
$ok = stripos($resultado, 'correctamente') !== false;

echo json_encode([
    'status' => $ok ? '1' : '0',
    'mensaje' => $resultado
]);
?>
