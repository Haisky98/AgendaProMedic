<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_hora_cita_dal.php';

header('Content-Type: application/json; charset=utf-8');

$idHora = isset($_POST['id_hora']) ? (int)$_POST['id_hora'] : 0;
if ($idHora <= 0) {
    echo json_encode(['success' => false, 'message' => 'No se recibió un horario válido.']);
    exit;
}

$objHora = new hora_cita_dal();
$resultadoRaw = $objHora->delete_hora_cita($idHora);
$resultado = is_string($resultadoRaw) ? json_decode($resultadoRaw, true) : (array)$resultadoRaw;

if (!empty($resultado['bool'])) {
    echo json_encode(['success' => true, 'message' => 'Horario eliminado correctamente.']);
    exit;
}

echo json_encode([
    'success' => false,
    'message' => $resultado['error'] ?? 'No se pudo eliminar el horario. Puede tener citas asociadas.'
]);
?>
