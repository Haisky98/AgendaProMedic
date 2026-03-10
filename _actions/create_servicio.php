<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_cat_servicios_dal.php");
header('Content-Type: application/json');
if (
    isset($_POST['id_especialidad']) && !empty($_POST['id_especialidad']) &&
    isset($_POST['nombre']) && !empty(trim($_POST['nombre']))
) {
    $id_especialidad = (int)$_POST['id_especialidad'];
    if ($id_especialidad <= 0) {
        echo json_encode(['success' => false, 'message' => 'Selecciona una especialidad válida.']);
        exit;
    }

    $nombre = trim($_POST['nombre']);
    $duracion = isset($_POST['duracion_estimada_minutos']) ? $_POST['duracion_estimada_minutos'] : 30;
    $costo = isset($_POST['costo']) ? $_POST['costo'] : 0.00;
    $activo = isset($_POST['activo']) ? $_POST['activo'] : 1;
    
    $obj = new servicios_dal();
    $resultado = $obj->create_servicio($id_especialidad, $nombre, $duracion, $costo, $activo);
    
    echo json_encode(['success' => $resultado['bool'], 'message' => $resultado['bool'] ? 'Registrado.' : 'Error al guardar.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios.']);
}
?>

