<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_cat_consultorios_dal.php';

header('Content-Type: application/json; charset=utf-8');

$idConsultorio = isset($_POST['id_consultorio']) ? (int)$_POST['id_consultorio'] : 0;
$numeroSala = isset($_POST['numero_sala']) ? trim($_POST['numero_sala']) : '';
$ubicacion = isset($_POST['ubicacion']) ? trim($_POST['ubicacion']) : '';
$activo = isset($_POST['activo']) ? (int)$_POST['activo'] : 1;

if ($idConsultorio <= 0 || $numeroSala === '' || $ubicacion === '') {
    echo json_encode(['success' => false, 'message' => 'Faltan datos para actualizar el consultorio.']);
    exit;
}

$objConsultorios = new consultorios_dal();
$resultadoRaw = $objConsultorios->update_consultorio($idConsultorio, $numeroSala, $ubicacion, $activo);
$resultado = is_string($resultadoRaw) ? json_decode($resultadoRaw, true) : (array)$resultadoRaw;

if (!empty($resultado['bool'])) {
    echo json_encode(['success' => true, 'message' => 'Consultorio actualizado correctamente.']);
    exit;
}

echo json_encode([
    'success' => false,
    'message' => $resultado['error'] ?? 'No se pudo actualizar el consultorio.'
]);
?>
