<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_hora_cita_dal.php';

header('Content-Type: application/json; charset=utf-8');

$idHora = isset($_POST['id_hora']) ? (int)$_POST['id_hora'] : 0;
$activo = isset($_POST['activo']) ? (int)$_POST['activo'] : -1;

if ($idHora <= 0 || ($activo !== 0 && $activo !== 1)) {
    echo json_encode(['success' => false, 'message' => 'Parámetros inválidos.']);
    exit;
}

$objHora = new hora_cita_dal();
$resultadoRaw = $objHora->update_estatus_hora_cita($idHora, $activo);
$resultado = is_string($resultadoRaw) ? json_decode($resultadoRaw, true) : (array)$resultadoRaw;

if (!empty($resultado['bool'])) {
    echo json_encode([
        'success' => true,
        'message' => $activo === 1 ? 'Horario activado.' : 'Horario desactivado.'
    ]);
    exit;
}

echo json_encode([
    'success' => false,
    'message' => $resultado['error'] ?? 'No se pudo cambiar el estatus.'
]);
?>
