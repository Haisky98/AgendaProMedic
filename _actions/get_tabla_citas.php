<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_citas_dal.php");

$obj_citas = new citas_dal();
$rolActual = agp_current_role();
$fechaFiltro = isset($_POST['fecha']) ? trim($_POST['fecha']) : '';
$fechaFiltro = $fechaFiltro !== '' ? $fechaFiltro : null;

if ($rolActual === 'medico') {
    $idMedico = isset($_SESSION['id_medico']) ? (int)$_SESSION['id_medico'] : 0;
    $lista_citas = $idMedico > 0 ? $obj_citas->read_citas($idMedico, $fechaFiltro) : [];
} else {
    $lista_citas = $obj_citas->read_citas(null, $fechaFiltro);
}


echo json_encode($lista_citas);
?>

