<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_medicos_dal.php");
header('Content-Type: application/json');

if (isset($_POST['id_medico']) && !empty($_POST['id_medico'])) {
    $id_medico = $_POST['id_medico'];
    $obj_medicos = new medicos_dal();
    $resultado = $obj_medicos->delete_medico($id_medico);

    if ($resultado) {
        echo json_encode([
            'success' => true,
            'mensaje' => 'Médico eliminado del sistema.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'mensaje' => 'No se puede eliminar. Este médico ya tiene un historial de citas agendadas. Por favor, edítalo y cambia su estatus a "Inactivo" en lugar de eliminarlo.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'mensaje' => 'No se proporcionó el ID del médico.'
    ]);
}
?>
