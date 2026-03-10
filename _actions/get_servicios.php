<?php
include_once("../_class/class_cat_servicios_dal.php");
header('Content-Type: application/json; charset=utf-8');

$obj_servicios = new servicios_dal();
$idEspecialidad = null;

if (isset($_POST['id_especialidad']) && (int)$_POST['id_especialidad'] > 0) {
    $idEspecialidad = (int)$_POST['id_especialidad'];
} elseif (isset($_GET['id_especialidad']) && (int)$_GET['id_especialidad'] > 0) {
    $idEspecialidad = (int)$_GET['id_especialidad'];
}

$lista_servicios = $obj_servicios->get_servicios_select($idEspecialidad);

echo json_encode($lista_servicios, JSON_UNESCAPED_UNICODE);
?>
