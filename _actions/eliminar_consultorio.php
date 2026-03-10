<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_cat_consultorios_dal.php';

header('Content-Type: application/json; charset=utf-8');

$idConsultorio = isset($_POST['id_consultorio']) ? (int)$_POST['id_consultorio'] : 0;
if ($idConsultorio <= 0) {
    echo json_encode(['success' => false, 'message' => 'No se recibió un consultorio válido.']);
    exit;
}

$objConsultorios = new consultorios_dal();
$resultadoRaw = $objConsultorios->delete_consultorio($idConsultorio);
$resultado = is_string($resultadoRaw) ? json_decode($resultadoRaw, true) : (array)$resultadoRaw;

if (!empty($resultado['bool'])) {
    echo json_encode(['success' => true, 'message' => 'Consultorio eliminado correctamente.']);
    exit;
}

echo json_encode([
    'success' => false,
    'message' => $resultado['error'] ?? 'No se pudo eliminar el consultorio. Puede tener médicos asociados.'
]);
?>
