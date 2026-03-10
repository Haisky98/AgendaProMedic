<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_hora_cita_dal.php';

header('Content-Type: application/json; charset=utf-8');

$horaInicio = isset($_POST['hora_inicio']) ? trim($_POST['hora_inicio']) : '';
$horaFin = isset($_POST['hora_fin']) ? trim($_POST['hora_fin']) : '';
$etiqueta = isset($_POST['etiqueta']) ? trim($_POST['etiqueta']) : '';
$turno = isset($_POST['turno']) ? trim($_POST['turno']) : '';
$activo = isset($_POST['activo']) ? (int)$_POST['activo'] : 1;

if ($horaInicio === '' || $horaFin === '') {
    echo json_encode(['success' => false, 'message' => 'Debes capturar hora de inicio y fin.']);
    exit;
}

if (strtotime($horaFin) <= strtotime($horaInicio)) {
    echo json_encode(['success' => false, 'message' => 'La hora de fin debe ser mayor a la hora de inicio.']);
    exit;
}

if ($etiqueta === '') {
    $etiqueta = substr($horaInicio, 0, 5) . ' - ' . substr($horaFin, 0, 5);
}

if ($turno === '') {
    $turno = ((int)substr($horaInicio, 0, 2) < 13) ? 'Matutino' : 'Vespertino';
}

$objHora = new hora_cita_dal();
$resultado = $objHora->create_hora_cita($horaInicio, $horaFin, $etiqueta, $turno, $activo);

if (!empty($resultado['bool'])) {
    echo json_encode(['success' => true, 'message' => 'Bloque de horario creado correctamente.']);
    exit;
}

echo json_encode([
    'success' => false,
    'message' => $resultado['error'] ?? 'No se pudo guardar el horario.'
]);
?>
