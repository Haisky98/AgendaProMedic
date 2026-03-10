<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_cat_consultorios_dal.php';

header('Content-Type: application/json; charset=utf-8');

$idConsultorio = isset($_POST['id_consultorio']) ? (int)$_POST['id_consultorio'] : 0;
$activo = isset($_POST['activo']) ? (int)$_POST['activo'] : -1;

if ($idConsultorio <= 0 || ($activo !== 0 && $activo !== 1)) {
    echo json_encode(['success' => false, 'message' => 'Parámetros inválidos.']);
    exit;
}

$objConsultorios = new consultorios_dal();
$resultadoRaw = $objConsultorios->update_estatus_consultorio($idConsultorio, $activo);
$resultado = is_string($resultadoRaw) ? json_decode($resultadoRaw, true) : (array)$resultadoRaw;

if (!empty($resultado['bool'])) {
    echo json_encode([
        'success' => true,
        'message' => $activo === 1 ? 'Consultorio activado.' : 'Consultorio desactivado.'
    ]);
    exit;
}

echo json_encode([
    'success' => false,
    'message' => $resultado['error'] ?? 'No se pudo cambiar el estatus del consultorio.'
]);
?>
