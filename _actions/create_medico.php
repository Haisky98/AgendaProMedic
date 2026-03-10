<?php
require_once __DIR__ . '/auth_guard.php';
include_once("../_class/class_medicos_dal.php");
header('Content-Type: application/json');

if (
    isset($_POST['nombre_completo']) && !empty(trim($_POST['nombre_completo'])) &&
    isset($_POST['cedula_profesional']) && !empty(trim($_POST['cedula_profesional'])) &&
    isset($_POST['id_especialidad']) && !empty($_POST['id_especialidad'])
) {
    $nombre = trim($_POST['nombre_completo']);
    $cedula = trim($_POST['cedula_profesional']);
    $id_especialidad = $_POST['id_especialidad'];
    $id_consultorio = !empty($_POST['id_consultorio']) ? $_POST['id_consultorio'] : null;
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
    $activo = isset($_POST['activo']) ? $_POST['activo'] : 1;

    $obj_medicos = new medicos_dal();
    $resultado = $obj_medicos->create_medico($nombre, $cedula, $id_especialidad, $id_consultorio, $telefono, $correo, $activo);

    if ($resultado['bool']) {
        echo json_encode([
            'success' => true,
            'message' => 'Médico registrado correctamente.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al guardar. Es posible que la cédula profesional ya esté registrada en otro médico.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan datos obligatorios (nombre, cédula o especialidad).'
    ]);
}
?>
