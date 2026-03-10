<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_cat_especialidades_dal.php");
header('Content-Type: application/json');


if (isset($_POST['nombre']) && !empty(trim($_POST['nombre']))) {
    
    $nombre = trim($_POST['nombre']);
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
    $activo = isset($_POST['activo']) ? $_POST['activo'] : 1;
    
    $obj_especialidades = new especialidades_dal();
    $resultado = $obj_especialidades->create_especialidad($nombre, $descripcion, $activo);
    
    if ($resultado['bool']) {
        echo json_encode([
            'success' => true,
            'message' => 'Especialidad registrada correctamente.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al guardar en la base de datos.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'El nombre de la especialidad es obligatorio.'
    ]);
}
?>

