<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_cat_especialidades_dal.php");
header('Content-Type: application/json');

if (isset($_POST['id_especialidad']) && !empty($_POST['id_especialidad'])) {
    $id_especialidad = $_POST['id_especialidad'];
    $obj_especialidades = new especialidades_dal();
    $resultado = $obj_especialidades->delete_especialidad($id_especialidad);

    if ($resultado) {
        echo json_encode([
            'success' => true,
            'mensaje' => 'Especialidad eliminada correctamente.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'mensaje' => 'No se pudo eliminar. Es posible que existan médicos asignados a esta especialidad. Te recomendamos cambiar su estatus a "Inactivo" al editarla.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'mensaje' => 'No se proporcionó el ID de la especialidad.'
    ]);
}
?>
