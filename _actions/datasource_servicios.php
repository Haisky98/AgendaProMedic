<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_cat_servicios_dal.php");
header('Content-Type: application/json');
$obj_servicios = new servicios_dal();
echo json_encode($obj_servicios->read_servicio());
?>

