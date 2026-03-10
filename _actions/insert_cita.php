<?php
include_once("../_class/class_citas_dal.php");
include_once("../_class/class_mailer.php");

header('Content-Type: application/json');

if (
    isset($_POST['nombre']) && !empty($_POST['nombre']) &&
    isset($_POST['telefono']) && !empty($_POST['telefono']) &&
    isset($_POST['id_medico']) && !empty($_POST['id_medico']) &&
    isset($_POST['id_servicio']) && !empty($_POST['id_servicio']) &&
    isset($_POST['fecha']) && !empty($_POST['fecha']) &&
    isset($_POST['id_hora']) && !empty($_POST['id_hora'])
) {
   
    $curp = isset($_POST['curp']) ? $_POST['curp'] : '';
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    
    $id_medico = $_POST['id_medico'];
    $id_servicio = $_POST['id_servicio'];
    $id_hora = $_POST['id_hora'];
    $fecha_cita = $_POST['fecha'];
    $motivo = isset($_POST['motivo']) ? $_POST['motivo'] : '';

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
    } else {
        echo json_encode([
            'success' => false,
            'message' => isset($resultado['message']) ? $resultado['message'] : 'Error al guardar en la base de datos.'
        ]);
    }
    
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Faltan datos obligatorios en el formulario.'
    ]);
}
?>
