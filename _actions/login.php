<?php
require_once __DIR__ . '/../_class/session_helper.php';
require_once __DIR__ . '/../_class/class_usuarios_dal.php';

agp_session_start();
header('Content-Type: application/json; charset=utf-8');

$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$password = $_POST['password'] ?? '';

if ($usuario === '' || $password === '') {
    echo json_encode([
        'success' => 0,
        'message' => 'Debes capturar usuario y contraseña.'
    ]);
    exit;
}

$usuarioDAL = new class_usuario_dal();
$datosUsuario = $usuarioDAL->validar_usuario($usuario, $password);

if (!$datosUsuario) {
    echo json_encode([
        'success' => 0,
        'message' => 'Credenciales inválidas o usuario inactivo.'
    ]);
    exit;
}

agp_login_user([
    'id' => $datosUsuario['id'],
    'usuario' => $datosUsuario['usuario'] ?? $usuario,
    'rol' => $datosUsuario['rol'],
    'nombre' => $datosUsuario['nombre'],
    'id_medico' => isset($datosUsuario['id_medico']) ? (int)$datosUsuario['id_medico'] : 0
]);

echo json_encode([
    'success' => 1,
    'message' => 'Inicio de sesión correcto.'
]);
?>
