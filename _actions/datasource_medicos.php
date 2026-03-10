<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_medicos_dal.php");

header('Content-Type: application/json');

$obj_medicos = new medicos_dal();

$lista_medicos = $obj_medicos->read_medicos();

echo json_encode($lista_medicos);
?>

