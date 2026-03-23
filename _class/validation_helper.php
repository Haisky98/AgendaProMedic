<?php
if (!function_exists('agp_len')) {
    function agp_len($value)
    {
        $text = (string)$value;
        return function_exists('mb_strlen') ? mb_strlen($text, 'UTF-8') : strlen($text);
    }
}

if (!function_exists('agp_validar_usuario_login')) {
    function agp_validar_usuario_login($usuario)
    {
        $usuario = trim((string)$usuario);
        if ($usuario === '') {
            return [false, $usuario, 'Debes capturar el usuario.'];
        }

        if (agp_len($usuario) < 3 || agp_len($usuario) > 50) {
            return [false, $usuario, 'El usuario debe tener entre 3 y 50 caracteres.'];
        }

        if (!preg_match('/^[A-Za-z0-9._-]+$/', $usuario)) {
            return [false, $usuario, 'El usuario solo puede contener letras, números, punto, guion y guion bajo.'];
        }

        return [true, $usuario, ''];
    }
}

if (!function_exists('agp_validar_nombre_persona')) {
    function agp_validar_nombre_persona($nombre, $min = 3, $max = 150)
    {
        $nombre = trim((string)$nombre);
        if ($nombre === '') {
            return [false, $nombre, 'El nombre es obligatorio.'];
        }

        $len = agp_len($nombre);
        if ($len < $min || $len > $max) {
            return [false, $nombre, "El nombre debe tener entre $min y $max caracteres."];
        }

        if (!preg_match('/^[\p{L}\p{M} .,\-\'"]+$/u', $nombre)) {
            return [false, $nombre, 'El nombre contiene caracteres no permitidos.'];
        }

        return [true, $nombre, ''];
    }
}

if (!function_exists('agp_validar_telefono_mx')) {
    function agp_validar_telefono_mx($telefono)
    {
        $telefono = trim((string)$telefono);
        $soloDigitos = preg_replace('/\D+/', '', $telefono);

        if ($soloDigitos === '' || strlen($soloDigitos) !== 10) {
            return [false, $soloDigitos, 'El teléfono debe tener exactamente 10 dígitos.'];
        }

        return [true, $soloDigitos, ''];
    }
}

if (!function_exists('agp_validar_email_opcional')) {
    function agp_validar_email_opcional($correo, $max = 120)
    {
        $correo = trim((string)$correo);
        if ($correo === '') {
            return [true, '', ''];
        }

        if (agp_len($correo) > $max) {
            return [false, $correo, "El correo no puede exceder $max caracteres."];
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return [false, $correo, 'El correo electrónico no es válido.'];
        }

        return [true, $correo, ''];
    }
}

if (!function_exists('agp_validar_curp_opcional')) {
    function agp_validar_curp_opcional($curp)
    {
        $curp = strtoupper(trim((string)$curp));
        if ($curp === '') {
            return [true, '', ''];
        }

        if (!preg_match('/^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z0-9]\d$/', $curp)) {
            return [false, $curp, 'La CURP no tiene un formato válido.'];
        }

        return [true, $curp, ''];
    }
}

if (!function_exists('agp_validar_entero_positivo')) {
    function agp_validar_entero_positivo($value, $fieldLabel)
    {
        $intVal = (int)$value;
        if ($intVal <= 0) {
            return [false, 0, "El campo $fieldLabel es inválido."];
        }

        return [true, $intVal, ''];
    }
}

if (!function_exists('agp_validar_fecha_cita')) {
    function agp_validar_fecha_cita($fecha, $timezone = 'America/Mexico_City')
    {
        $fecha = trim((string)$fecha);
        $dt = DateTime::createFromFormat('Y-m-d', $fecha, new DateTimeZone($timezone));

        if (!$dt || $dt->format('Y-m-d') !== $fecha) {
            return [false, $fecha, 'La fecha de cita no es válida.'];
        }

        $hoy = new DateTime('today', new DateTimeZone($timezone));
        if ($dt < $hoy) {
            return [false, $fecha, 'La fecha de cita no puede ser anterior a hoy.'];
        }

        return [true, $fecha, ''];
    }
}

if (!function_exists('agp_validar_longitud_texto')) {
    function agp_validar_longitud_texto($value, $fieldLabel, $min = 0, $max = 255, $required = false)
    {
        $value = trim((string)$value);
        $len = agp_len($value);

        if ($required && $value === '') {
            return [false, $value, "El campo $fieldLabel es obligatorio."];
        }

        if ($value === '') {
            return [true, '', ''];
        }

        if ($len < $min || $len > $max) {
            return [false, $value, "El campo $fieldLabel debe tener entre $min y $max caracteres."];
        }

        return [true, $value, ''];
    }
}

if (!function_exists('agp_validar_password_basico')) {
    function agp_validar_password_basico($password, $min = 6, $max = 72)
    {
        $password = (string)$password;
        $len = agp_len($password);

        if ($len < $min || $len > $max) {
            return [false, $password, "La contraseña debe tener entre $min y $max caracteres."];
        }

        return [true, $password, ''];
    }
}
?>
