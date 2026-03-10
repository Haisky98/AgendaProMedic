<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_cat_consultorios_dal.php';

header('Content-Type: application/json; charset=utf-8');

$objConsultorios = new consultorios_dal();
$lista = $objConsultorios->read_consultorio();

echo json_encode($lista, JSON_UNESCAPED_UNICODE);
?>
