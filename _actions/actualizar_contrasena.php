<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_usuarios_dal.php';

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

$dal = new class_usuario_dal();
$resultado = $dal->actualizar_contrasena($usuario, $actual, $nueva, $confirmar);
$ok = stripos($resultado, 'correctamente') !== false;

echo json_encode([
    'status' => $ok ? '1' : '0',
    'mensaje' => $resultado
]);
?>
