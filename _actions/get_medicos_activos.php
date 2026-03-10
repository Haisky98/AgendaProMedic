<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_usuarios_dal.php';
header('Content-Type: application/json; charset=utf-8');

agp_require_role_json(['admin']);

$usuariosDal = new class_usuario_dal();
echo json_encode($usuariosDal->get_medicos_activos(), JSON_UNESCAPED_UNICODE);
?>
