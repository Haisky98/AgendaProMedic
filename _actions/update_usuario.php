<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_usuarios_dal.php';
require_once __DIR__ . '/../_class/validation_helper.php';
header('Content-Type: application/json; charset=utf-8');

agp_require_role_json(['admin']);

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$idMedico = isset($_POST['id_medico']) ? (int)$_POST['id_medico'] : 0;
$activo = isset($_POST['activo']) ? (int)$_POST['activo'] : 1;
$password = $_POST['password'] ?? '';
$passwordConfirm = $_POST['password_confirm'] ?? '';

if ($id <= 0 || $usuario === '' || $nombre === '' || $idMedico <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Debes completar id, usuario, nombre y médico.'
    ]);
    exit;
}

$validUsuario = agp_validar_usuario_login($usuario);
if (!$validUsuario[0]) {
    echo json_encode([
        'success' => false,
        'message' => $validUsuario[2]
    ]);
    exit;
}
$usuario = $validUsuario[1];

$validNombre = agp_validar_nombre_persona($nombre, 3, 120);
if (!$validNombre[0]) {
    echo json_encode([
        'success' => false,
        'message' => $validNombre[2]
    ]);
    exit;
}
$nombre = $validNombre[1];

$validIdMedico = agp_validar_entero_positivo($idMedico, 'médico');
if (!$validIdMedico[0]) {
    echo json_encode([
        'success' => false,
        'message' => $validIdMedico[2]
    ]);
    exit;
}
$idMedico = $validIdMedico[1];

if (!in_array($activo, [0, 1], true)) {
    echo json_encode([
        'success' => false,
        'message' => 'El estatus enviado es inválido.'
    ]);
    exit;
}

if ($password !== '' || $passwordConfirm !== '') {
    if ($password === '' || $passwordConfirm === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Si deseas cambiar la contraseña, captura ambos campos.'
        ]);
        exit;
    }

    if ($password !== $passwordConfirm) {
        echo json_encode([
            'success' => false,
            'message' => 'La confirmación de contraseña no coincide.'
        ]);
        exit;
    }

    $validPassword = agp_validar_password_basico($password, 6, 72);
    if (!$validPassword[0]) {
        echo json_encode([
            'success' => false,
            'message' => $validPassword[2]
        ]);
        exit;
    }
}

$usuariosDal = new class_usuario_dal();
$resultado = $usuariosDal->update_usuario_medico($id, $usuario, $nombre, $idMedico, $activo, $password);

echo json_encode([
    'success' => !empty($resultado['bool']),
    'message' => $resultado['message'] ?? 'No fue posible actualizar el usuario.'
], JSON_UNESCAPED_UNICODE);
?>
