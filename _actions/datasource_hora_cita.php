<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_hora_cita_dal.php';

header('Content-Type: application/json; charset=utf-8');

$objHora = new hora_cita_dal();
$lista = $objHora->read_hora_cita();

echo json_encode($lista, JSON_UNESCAPED_UNICODE);
?>
