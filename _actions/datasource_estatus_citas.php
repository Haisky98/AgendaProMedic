<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_cat_estatus_cita_dal.php';
header('Content-Type: application/json');

agp_require_role_json(['admin']);

$obj_estatus = new estatus_cita_dal();

echo json_encode($obj_estatus->read_estatus_cita());
?>
