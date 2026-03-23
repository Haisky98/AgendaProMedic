<?php
include_once("../_class/class_citas_dal.php");
include_once("../_class/class_mailer.php");
require_once __DIR__ . '/../_class/validation_helper.php';

header('Content-Type: application/json; charset=utf-8');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
    ]);
    exit;
}

$curp = isset($_POST['curp']) ? $_POST['curp'] : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
$correo = isset($_POST['correo']) ? $_POST['correo'] : '';
$id_medico = isset($_POST['id_medico']) ? $_POST['id_medico'] : 0;
$id_servicio = isset($_POST['id_servicio']) ? $_POST['id_servicio'] : 0;
$fecha_cita = isset($_POST['fecha']) ? $_POST['fecha'] : '';
$id_hora = isset($_POST['id_hora']) ? $_POST['id_hora'] : 0;
$motivo = isset($_POST['motivo']) ? $_POST['motivo'] : '';

$validCurp = agp_validar_curp_opcional($curp);
if (!$validCurp[0]) {
    echo json_encode(['success' => false, 'message' => $validCurp[2]]);
    exit;
}
$curp = $validCurp[1];

$validNombre = agp_validar_nombre_persona($nombre, 3, 150);
if (!$validNombre[0]) {
    echo json_encode(['success' => false, 'message' => $validNombre[2]]);
    exit;
}
$nombre = $validNombre[1];

$validTelefono = agp_validar_telefono_mx($telefono);
if (!$validTelefono[0]) {
    echo json_encode(['success' => false, 'message' => $validTelefono[2]]);
    exit;
}
$telefono = $validTelefono[1];

$validCorreo = agp_validar_email_opcional($correo, 100);
if (!$validCorreo[0]) {
    echo json_encode(['success' => false, 'message' => $validCorreo[2]]);
    exit;
}
$correo = $validCorreo[1];

$validMedico = agp_validar_entero_positivo($id_medico, 'médico');
if (!$validMedico[0]) {
    echo json_encode(['success' => false, 'message' => $validMedico[2]]);
    exit;
}
$id_medico = $validMedico[1];

$validServicio = agp_validar_entero_positivo($id_servicio, 'servicio');
if (!$validServicio[0]) {
    echo json_encode(['success' => false, 'message' => $validServicio[2]]);
    exit;
}
$id_servicio = $validServicio[1];

$validHora = agp_validar_entero_positivo($id_hora, 'hora');
if (!$validHora[0]) {
    echo json_encode(['success' => false, 'message' => $validHora[2]]);
    exit;
}
$id_hora = $validHora[1];

$validFecha = agp_validar_fecha_cita($fecha_cita, 'America/Mexico_City');
if (!$validFecha[0]) {
    echo json_encode(['success' => false, 'message' => $validFecha[2]]);
    exit;
}
$fecha_cita = $validFecha[1];

$validMotivo = agp_validar_longitud_texto($motivo, 'motivo', 5, 500, true);
if (!$validMotivo[0]) {
    echo json_encode(['success' => false, 'message' => $validMotivo[2]]);
    exit;
}
$motivo = $validMotivo[1];

$id_estatus = 1;

$obj_citas = new citas_dal();
$resultado = $obj_citas->create_cita(
    $curp,
    $nombre,
    $telefono,
    $correo,
    $id_medico,
    $id_servicio,
    $id_hora,
    $id_estatus,
    $fecha_cita,
    $motivo
);

if ($resultado['bool']) {
    $mail_sent = null;
    $mail_error = '';
    $id_cita = isset($resultado['id_cita']) ? (int)$resultado['id_cita'] : 0;

    if ($id_cita > 0) {
        $detalle_cita = $obj_citas->get_cita_detalle($id_cita);

        if (is_array($detalle_cita) && !empty(trim((string)$detalle_cita['correo_paciente']))) {
            $mailer = new mailer_service();
            if ($mailer->is_enabled()) {
                $mail_sent = $mailer->send_cita_confirmacion($detalle_cita);
                if (!$mail_sent) {
                    $mail_error = $mailer->get_last_error();
                }
            }
        }
    }

    $message = 'Cita registrada correctamente.';
    if ($mail_sent === false) {
        $message .= ' Nota: no se pudo enviar el correo de confirmación.';
    }

    echo json_encode([
        'success' => true,
        'message' => $message,
        'id_cita' => $id_cita,
        'mail_sent' => $mail_sent,
        'mail_error' => $mail_error
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode([
    'success' => false,
    'message' => isset($resultado['message']) ? $resultado['message'] : 'Error al guardar en la base de datos.'
]);
?>
