<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_medicos_dal.php");
header('Content-Type: application/json');

if (
    isset($_POST['id_medico']) && !empty($_POST['id_medico']) &&
    isset($_POST['nombre_completo']) && !empty(trim($_POST['nombre_completo'])) &&
    isset($_POST['cedula_profesional']) && !empty(trim($_POST['cedula_profesional'])) &&
    isset($_POST['id_especialidad']) && !empty($_POST['id_especialidad'])
) {
    $id_medico = $_POST['id_medico'];
    $nombre = trim($_POST['nombre_completo']);
    $cedula = trim($_POST['cedula_profesional']);
    $id_especialidad = $_POST['id_especialidad'];
    $id_consultorio = !empty($_POST['id_consultorio']) ? $_POST['id_consultorio'] : null;
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
    $activo = isset($_POST['activo']) ? $_POST['activo'] : 1;

    $obj_medicos = new medicos_dal();
    $resultado = $obj_medicos->update_medico($id_medico, $nombre, $cedula, $id_especialidad, $id_consultorio, $telefono, $correo, $activo);

    if ($resultado) {
        echo json_encode([
            'success' => true,
            'message' => 'Médico actualizado correctamente.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Hubo un problema al actualizar la base de datos o la cédula ya está en uso.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan datos obligatorios para actualizar.'
    ]);
}
?>
