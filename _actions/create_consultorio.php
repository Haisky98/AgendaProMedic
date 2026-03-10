<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_cat_consultorios_dal.php';

header('Content-Type: application/json; charset=utf-8');

$numeroSala = isset($_POST['numero_sala']) ? trim($_POST['numero_sala']) : '';
$ubicacion = isset($_POST['ubicacion']) ? trim($_POST['ubicacion']) : '';
$activo = isset($_POST['activo']) ? (int)$_POST['activo'] : 1;

if ($numeroSala === '' || $ubicacion === '') {
    echo json_encode(['success' => false, 'message' => 'Número/sala y ubicación son obligatorios.']);
    exit;
}

$objConsultorios = new consultorios_dal();
$resultado = $objConsultorios->create_consultorio($numeroSala, $ubicacion, $activo);

if (!empty($resultado['bool'])) {
    echo json_encode(['success' => true, 'message' => 'Consultorio registrado correctamente.']);
    exit;
}

echo json_encode([
    'success' => false,
    'message' => $resultado['error'] ?? 'No se pudo registrar el consultorio.'
]);
?>
