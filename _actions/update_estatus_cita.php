<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_cat_estatus_cita_dal.php");
include_once("../_class/class_citas_dal.php");
header('Content-Type: application/json');

if (
    isset($_POST['id_cita']) && !empty($_POST['id_cita']) &&
    isset($_POST['id_estatus']) && !empty($_POST['id_estatus'])
) {
    $id_cita = (int)$_POST['id_cita'];
    $id_estatus = (int)$_POST['id_estatus'];

    $obj_citas = new citas_dal();
    $resultado_raw = $obj_citas->update_estatus_cita($id_cita, $id_estatus);
    $resultado = json_decode($resultado_raw, true);

    echo json_encode([
        'success' => is_array($resultado) && !empty($resultado['bool']),
        'message' => (is_array($resultado) && !empty($resultado['bool']))
            ? 'Estatus de la cita actualizado.'
            : (is_array($resultado) && isset($resultado['error']) ? $resultado['error'] : 'Error al actualizar estatus de la cita.')
    ]);
    exit;
}

if (
    isset($_POST['id_estatus']) && !empty($_POST['id_estatus']) &&
    isset($_POST['nombre']) && !empty(trim($_POST['nombre']))
) {
    $id_estatus = (int)$_POST['id_estatus'];
    $nombre = trim($_POST['nombre']);
    $activo = isset($_POST['activo']) ? (int)$_POST['activo'] : 1;

    $obj_estatus = new estatus_cita_dal();
    $resultado_raw = $obj_estatus->update_estatus_cita($id_estatus, $nombre, $activo);
    $resultado = json_decode($resultado_raw, true);

    echo json_encode([
        'success' => is_array($resultado) && !empty($resultado['bool']),
        'message' => (is_array($resultado) && !empty($resultado['bool']))
            ? 'Estatus del catálogo actualizado.'
            : (is_array($resultado) && isset($resultado['error']) ? $resultado['error'] : 'Error al actualizar estatus del catálogo.')
    ]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Faltan datos.']);
?>
