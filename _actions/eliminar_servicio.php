<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_cat_servicios_dal.php");
header('Content-Type: application/json');

if (isset($_POST['id_servicio']) && !empty($_POST['id_servicio'])) {
    $obj = new servicios_dal();
    $resultado = $obj->delete_servicio($_POST['id_servicio']);

    echo json_encode([
        'success' => (bool)$resultado,
        'mensaje' => $resultado
            ? 'Servicio eliminado.'
            : 'No se pudo eliminar. Puede que ya existan citas usando este servicio (te sugerimos ponerlo en "Inactivo").'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'mensaje' => 'No se proporcionó el ID.'
    ]);
}
?>
