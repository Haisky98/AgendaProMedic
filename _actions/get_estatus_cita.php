<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_cat_estatus_cita_dal.php");

$obj_estatus = new estatus_cita_dal();

$lista_estatus = $obj_estatus->get_estatus_cita_select();

echo json_encode($lista_estatus);
?>

