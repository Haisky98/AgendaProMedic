<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_cat_especialidades_dal.php");
header('Content-Type: application/json');

if (isset($_POST['id_especialidad']) && !empty($_POST['id_especialidad']) && 
    isset($_POST['nombre']) && !empty(trim($_POST['nombre']))) {
    
    $id_especialidad = $_POST['id_especialidad'];
    $nombre = trim($_POST['nombre']);
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
    $activo = isset($_POST['activo']) ? $_POST['activo'] : 1;
    
    $obj_especialidades = new especialidades_dal();
    $resultado = $obj_especialidades->update_especialidad($id_especialidad, $nombre, $descripcion, $activo);
    
    if ($resultado) {
        echo json_encode([
            'success' => true,
            'message' => 'Especialidad actualizada correctamente.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Hubo un problema al actualizar la base de datos.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan datos obligatorios para actualizar.'
    ]);
}
?>

