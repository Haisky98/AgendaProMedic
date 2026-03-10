<?php
include_once("../_class/class_cat_especialidades_dal.php");

$obj_especialidades = new especialidades_dal();
$lista_especialidades = $obj_especialidades->get_especialidades_select();
unset($obj_especialidades);

header('Content-Type: application/json; charset=utf-8');

echo json_encode($lista_especialidades, JSON_UNESCAPED_UNICODE);
?>