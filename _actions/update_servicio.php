<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_cat_servicios_dal.php");
header('Content-Type: application/json');
if (
    isset($_POST['id_servicio']) && !empty($_POST['id_servicio']) &&
    isset($_POST['id_especialidad']) && !empty($_POST['id_especialidad'])
) {
    $id = $_POST['id_servicio'];
    $id_especialidad = (int)$_POST['id_especialidad'];
    if ($id_especialidad <= 0) {
        echo json_encode(['success' => false, 'message' => 'Selecciona una especialidad válida.']);
        exit;
    }

    $nombre = trim($_POST['nombre']);
    $duracion = $_POST['duracion_estimada_minutos'];
    $costo = $_POST['costo'];
    $activo = $_POST['activo'];
    
    $obj = new servicios_dal();
    $resultado = $obj->update_servicio($id, $id_especialidad, $nombre, $duracion, $costo, $activo);
    
    echo json_encode(['success' => (bool)$resultado, 'message' => $resultado ? 'Actualizado.' : 'Error al actualizar.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Faltan datos.']);
}
?>

