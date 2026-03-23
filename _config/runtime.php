<?php
if (!function_exists('agp_bool_env')) {
    function agp_bool_env($value, $default = false)
    {
        if ($value === null || $value === '') {
            return (bool)$default;
        }

        $value = strtolower(trim((string)$value));
        return in_array($value, ['1', 'true', 'yes', 'on'], true);
    }
}

if (!function_exists('agp_configure_runtime')) {
    function agp_configure_runtime()
    {
        static $configured = false;
        if ($configured) {
            return;
        }
        $configured = true;

        error_reporting(E_ALL);
        if (function_exists('ini_set')) {
            ini_set('default_charset', 'UTF-8');
        }

        $appEnv = strtolower(trim((string)(getenv('APP_ENV') ?: ($_ENV['APP_ENV'] ?? 'production'))));
        $debug = agp_bool_env(getenv('APP_DEBUG') ?: ($_ENV['APP_DEBUG'] ?? ''), false);

        if ($appEnv === 'local' || $appEnv === 'development') {
            $debug = true;
        }

        $projectRoot = dirname(__DIR__);
        $logDir = $projectRoot . DIRECTORY_SEPARATOR . 'logs';
        $logFile = $logDir . DIRECTORY_SEPARATOR . 'php-error.log';

        if (!is_dir($logDir)) {
            @mkdir($logDir, 0775, true);
        }

        if (is_dir($logDir) && is_writable($logDir)) {
            if (function_exists('ini_set')) {
                ini_set('error_log', $logFile);
            }
        }

        if (function_exists('ini_set')) {
            ini_set('log_errors', '1');
            ini_set('display_errors', $debug ? '1' : '0');
            ini_set('display_startup_errors', $debug ? '1' : '0');
        }
    }
}

agp_configure_runtime();
?>
