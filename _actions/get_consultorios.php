<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_cat_consultorios_dal.php");
header('Content-Type: application/json');

$obj_consultorios = new consultorios_dal();

$lista_consultorios = $obj_consultorios->get_consultorios_select();

echo json_encode($lista_consultorios);
?>

