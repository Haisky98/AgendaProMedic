<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_cat_estatus_cita_dal.php");
header('Content-Type: application/json');

if (isset($_POST['nombre']) && !empty(trim($_POST['nombre']))) {
    $nombre = trim($_POST['nombre']);
    $activo = isset($_POST['activo']) ? $_POST['activo'] : 1; 
    
    $obj = new estatus_cita_dal();
    $resultado = $obj->create_estatus_cita($nombre, $activo);
    
    echo json_encode(['success' => $resultado['bool'], 'message' => $resultado['bool'] ? 'Registrado.' : 'Error al guardar.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Falta el nombre del estatus.']);
}
?>
