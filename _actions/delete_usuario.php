<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_usuarios_dal.php';
header('Content-Type: application/json; charset=utf-8');

agp_require_role_json(['admin']);

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$idSesion = isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0;

if ($id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Debes proporcionar un id de usuario valido.'
    ]);
    exit;
}

$usuariosDal = new class_usuario_dal();
$resultado = $usuariosDal->delete_usuario_medico($id, $idSesion);

echo json_encode([
    'success' => !empty($resultado['bool']),
    'message' => $resultado['message'] ?? 'No fue posible eliminar el usuario.'
], JSON_UNESCAPED_UNICODE);
?>
