<?php
include_once("../_class/class_cat_estatus_cita_dal.php");
header('Content-Type: application/json');
$obj_estatus = new estatus_cita_dal();

echo json_encode($obj_estatus->read_estatus_cita());
?>