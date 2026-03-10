<?php
include_once("../_class/class_citas_dal.php");
header('Content-Type: application/json');

if (isset($_POST['fecha']) && isset($_POST['id_medico']) && !empty($_POST['fecha']) && !empty($_POST['id_medico'])) {
    
    $fecha_cita = trim($_POST['fecha']);
    $id_medico = (int)$_POST['id_medico'];
    
    $obj_citas = new citas_dal();
    $horas_libres = $obj_citas->get_horas_disponibles($fecha_cita, $id_medico);

    echo json_encode($horas_libres);
    
} else {
    echo json_encode([]);
}
?>
