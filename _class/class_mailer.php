<?php

class mailer_service
{
    private $config = ['enabled' => false];
    private $last_error = '';

    public function __construct()
    {
        $this->config = $this->load_config();
    }

    public function is_enabled()
    {
        return !empty($this->config['enabled']);
    }

    public function get_last_error()
    {
        return $this->last_error;
    }

    public function send_cita_confirmacion($detalle)
    {
        $correo = isset($detalle['correo_paciente']) ? trim((string)$detalle['correo_paciente']) : '';
        if ($correo === '') {
            $this->last_error = 'No hay correo del paciente.';
            return false;
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $this->last_error = 'El correo del paciente no es válido.';
            return false;
        }

        if (!$this->is_enabled()) {
            $this->last_error = 'SMTP deshabilitado o sin configurar.';
            return false;
        }

        if (!$this->load_phpmailer()) {
            $this->last_error = 'PHPMailer no está instalado.';
            return false;
        }

        $mail = $this->build_mailer();
        if ($mail === null) {
            return false;
        }

        $nombrePaciente = isset($detalle['nombre_paciente']) ? trim((string)$detalle['nombre_paciente']) : 'Paciente';
        $fecha = $this->format_fecha(isset($detalle['fecha_cita']) ? (string)$detalle['fecha_cita'] : '');
        $hora = isset($detalle['hora']) ? trim((string)$detalle['hora']) : 'Por confirmar';
        $medico = isset($detalle['medico']) ? trim((string)$detalle['medico']) : 'Por confirmar';
        $servicio = isset($detalle['servicio']) ? trim((string)$detalle['servicio']) : 'Consulta';
        $motivo = isset($detalle['motivo']) ? trim((string)$detalle['motivo']) : '';
        $clinica = !empty($this->config['from_name']) ? trim((string)$this->config['from_name']) : 'Agenda Pro Medic';

        $html = $this->render_html_confirmacion($nombrePaciente, $fecha, $hora, $medico, $servicio, $motivo, $clinica);
        $texto = $this->render_text_confirmacion($nombrePaciente, $fecha, $hora, $medico, $servicio, $motivo, $clinica);

        try {
            $mail->addAddress($correo, $nombrePaciente);
            $mail->isHTML(true);
            $mail->Subject = 'Confirmación de cita médica - ' . $fecha;
            $mail->Body = $html;
            $mail->AltBody = $texto;
            $mail->send();
            return true;
        } catch (Exception $e) {
            $this->last_error = $e->getMessage();
            return false;
        }
    }

    private function load_config()
    {
        $configFile = __DIR__ . '/../_config/mail.php';
        if (!file_exists($configFile)) {
            return ['enabled' => false];
        }

        $config = include $configFile;
        if (!is_array($config)) {
            return ['enabled' => false];
        }

        return $config;
    }

    private function load_phpmailer()
    {
        if (class_exists('\\PHPMailer\\PHPMailer\\PHPMailer')) {
            return true;
        }

        $autoloadPath = __DIR__ . '/../vendor/autoload.php';
        if (file_exists($autoloadPath)) {
            require_once $autoloadPath;
            return class_exists('\\PHPMailer\\PHPMailer\\PHPMailer');
        }

        $required = ['Exception.php', 'PHPMailer.php', 'SMTP.php'];
        $candidatePaths = [
            __DIR__ . '/../_lib/PHPMailer/src',
            __DIR__ . '/../assets/_lib/PHPMailer/src'
        ];

        foreach ($candidatePaths as $srcPath) {
            $allFilesPresent = true;
            foreach ($required as $file) {
                if (!file_exists($srcPath . '/' . $file)) {
                    $allFilesPresent = false;
                    break;
                }
            }

            if (!$allFilesPresent) {
                continue;
            }

            foreach ($required as $file) {
                require_once $srcPath . '/' . $file;
            }
            return class_exists('\\PHPMailer\\PHPMailer\\PHPMailer');
        }

        return false;
    }

    private function build_mailer()
    {
        $required = ['host', 'port', 'username', 'password', 'from_email', 'from_name', 'encryption'];
        foreach ($required as $key) {
            if (empty($this->config[$key])) {
                $this->last_error = 'Falta configuración SMTP: ' . $key;
                return null;
            }
        }

        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $this->config['host'];
            $mail->Port = (int)$this->config['port'];
            $mail->SMTPAuth = array_key_exists('smtp_auth', $this->config) ? (bool)$this->config['smtp_auth'] : true;
            $mail->Username = $this->config['username'];
            $mail->Password = str_replace(' ', '', (string)$this->config['password']);
            $mail->CharSet = 'UTF-8';

            $encryption = strtolower((string)$this->config['encryption']);
            if ($encryption === 'tls' || $encryption === 'ssl') {
                $mail->SMTPSecure = $encryption;
            } else {
                $mail->SMTPSecure = false;
                $mail->SMTPAutoTLS = false;
            }

            $mail->setFrom($this->config['from_email'], $this->config['from_name']);

            if (!empty($this->config['reply_to_email'])) {
                $replyToName = !empty($this->config['reply_to_name']) ? $this->config['reply_to_name'] : '';
                $mail->addReplyTo($this->config['reply_to_email'], $replyToName);
            }

            return $mail;
        } catch (Exception $e) {
            $this->last_error = $e->getMessage();
            return null;
        }
    }

    private function format_fecha($fecha)
    {
        $ts = strtotime($fecha);
        if (!$ts) {
            return $fecha;
        }

        $meses = [
            1 => 'enero',
            2 => 'febrero',
            3 => 'marzo',
            4 => 'abril',
            5 => 'mayo',
            6 => 'junio',
            7 => 'julio',
            8 => 'agosto',
            9 => 'septiembre',
            10 => 'octubre',
            11 => 'noviembre',
            12 => 'diciembre'
        ];

        $dia = (int)date('d', $ts);
        $mes = (int)date('n', $ts);
        $anio = (int)date('Y', $ts);

        return $dia . ' de ' . $meses[$mes] . ' de ' . $anio;
    }

    private function render_html_confirmacion($nombre, $fecha, $hora, $medico, $servicio, $motivo, $clinica)
    {
        $motivoHtml = $motivo !== ''
            ? '<tr><td style="padding:8px 0;border-top:1px solid #e5e7eb;"><strong>Motivo:</strong> ' . $this->esc($motivo) . '</td></tr>'
            : '';

        return
            '<div style="font-family:Segoe UI,Arial,sans-serif;background:#f3f6fb;padding:24px;color:#1f2937;">' .
                '<div style="max-width:620px;margin:0 auto;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">' .
                    '<div style="background:#0d6efd;padding:20px 24px;color:#ffffff;">' .
                        '<h2 style="margin:0;font-size:22px;line-height:1.2;">Cita médica confirmada</h2>' .
                        '<p style="margin:8px 0 0;font-size:14px;opacity:.95;">' . $this->esc($clinica) . '</p>' .
                    '</div>' .
                    '<div style="padding:24px;">' .
                        '<p style="margin:0 0 14px;">Hola <strong>' . $this->esc($nombre) . '</strong>,</p>' .
                        '<p style="margin:0 0 16px;">Tu cita fue registrada correctamente. Aquí tienes el resumen:</p>' .
                        '<table cellpadding="0" cellspacing="0" style="width:100%;font-size:14px;border-collapse:collapse;">' .
                            '<tr><td style="padding:8px 0;"><strong>Fecha:</strong> ' . $this->esc($fecha) . '</td></tr>' .
                            '<tr><td style="padding:8px 0;border-top:1px solid #e5e7eb;"><strong>Horario:</strong> ' . $this->esc($hora) . '</td></tr>' .
                            '<tr><td style="padding:8px 0;border-top:1px solid #e5e7eb;"><strong>Médico:</strong> ' . $this->esc($medico) . '</td></tr>' .
                            '<tr><td style="padding:8px 0;border-top:1px solid #e5e7eb;"><strong>Servicio:</strong> ' . $this->esc($servicio) . '</td></tr>' .
                            $motivoHtml .
                        '</table>' .
                        '<p style="margin:18px 0 0;">Si necesitas reprogramar o cancelar, responde este correo o comunícate con la clínica.</p>' .
                    '</div>' .
                    '<div style="background:#f8fafc;padding:14px 24px;font-size:12px;color:#6b7280;">' .
                        'Este mensaje fue generado automáticamente por ' . $this->esc($clinica) . '.' .
                    '</div>' .
                '</div>' .
            '</div>';
    }

    private function render_text_confirmacion($nombre, $fecha, $hora, $medico, $servicio, $motivo, $clinica)
    {
        $lineas = [
            'Cita médica confirmada',
            '',
            'Hola ' . $nombre . ',',
            'Tu cita fue registrada correctamente en ' . $clinica . '.',
            'Fecha: ' . $fecha,
            'Horario: ' . $hora,
            'Médico: ' . $medico,
            'Servicio: ' . $servicio
        ];

        if ($motivo !== '') {
            $lineas[] = 'Motivo: ' . $motivo;
        }

        $lineas[] = '';
        $lineas[] = 'Si necesitas reprogramar o cancelar, responde este correo o comunícate con la clínica.';

        return implode("\n", $lineas);
    }

    private function esc($value)
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

?>
