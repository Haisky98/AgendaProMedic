<?php
include_once("../_class/class_medicos_dal.php");

if (isset($_POST['id_especialidad']) && !empty($_POST['id_especialidad'])) {
    
    $id_especialidad = $_POST['id_especialidad'];
    
    $obj_medicos = new medicos_dal();
    $lista_medicos = $obj_medicos->get_medicos_por_especialidad($id_especialidad);
    
    echo json_encode($lista_medicos);
    
} else {
    echo json_encode([]);
}
?>