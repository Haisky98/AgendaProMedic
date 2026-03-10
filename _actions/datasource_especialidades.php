<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_cat_especialidades_dal.php");

header('Content-Type: application/json');

$obj_especialidades = new especialidades_dal();


$lista_especialidades = $obj_especialidades->read_especialidad();


echo json_encode($lista_especialidades);
?>

