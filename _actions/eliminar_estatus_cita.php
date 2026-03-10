<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_cat_estatus_cita_dal.php");
header('Content-Type: application/json');
if (isset($_POST['id_estatus']) && !empty($_POST['id_estatus'])) {
    $obj = new estatus_cita_dal();
    $resultado = $obj->delete_estatus_cita($_POST['id_estatus']);
    echo json_encode([
        'success' => (bool)$resultado, 
        'mensaje' => $resultado ? 'Estatus eliminado.' : 'No se pudo eliminar. Ya existen citas que utilizan este estatus.'
    ]);
} else {
    echo json_encode(['success' => false, 'mensaje' => 'No se proporcionó ID.']);
}
?>
