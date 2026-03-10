<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_usuarios_dal.php';
header('Content-Type: application/json; charset=utf-8');

agp_require_role_json(['admin']);

$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$password = $_POST['password'] ?? '';
$passwordConfirm = $_POST['password_confirm'] ?? '';
$idMedico = isset($_POST['id_medico']) ? (int)$_POST['id_medico'] : 0;
$activo = isset($_POST['activo']) ? (int)$_POST['activo'] : 1;
$rol = strtolower(trim($_POST['rol'] ?? 'medico'));

if ($rol !== 'medico') {
    echo json_encode([
        'success' => false,
        'message' => 'Solo se permite registrar usuarios con rol medico.'
    ]);
    exit;
}

if ($usuario === '' || $nombre === '' || $password === '' || $passwordConfirm === '' || $idMedico <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Debes completar usuario, nombre, medico y contrasena.'
    ]);
    exit;
}

if ($password !== $passwordConfirm) {
    echo json_encode([
        'success' => false,
        'message' => 'La confirmacion de contrasena no coincide.'
    ]);
    exit;
}

if (strlen($password) < 6) {
    echo json_encode([
        'success' => false,
        'message' => 'La contrasena debe tener al menos 6 caracteres.'
    ]);
    exit;
}

$usuariosDal = new class_usuario_dal();
$resultado = $usuariosDal->create_usuario_medico($usuario, $password, $nombre, $idMedico, $activo);

echo json_encode([
    'success' => !empty($resultado['bool']),
    'message' => $resultado['message'] ?? 'No fue posible crear el usuario.'
], JSON_UNESCAPED_UNICODE);
?>
