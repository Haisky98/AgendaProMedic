<?php
if (!function_exists('agp_session_start')) {
    function agp_session_start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'secure' => $isHttps,
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            session_start();
        }
    }
}

if (!function_exists('agp_is_authenticated')) {
    function agp_is_authenticated()
    {
        agp_session_start();
        return !empty($_SESSION['auth']) && !empty($_SESSION['id']);
    }
}

if (!function_exists('agp_require_auth_page')) {
    function agp_require_auth_page($loginPath = '../login.php')
    {
        agp_session_start();
        if (agp_is_authenticated()) {
            return;
        }

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($isAjax) {
            http_response_code(401);
            echo 'Sesión expirada';
            exit;
        }

        header('Location: ' . $loginPath);
        exit;
    }
}

if (!function_exists('agp_require_auth_json')) {
    function agp_require_auth_json()
    {
        agp_session_start();
        if (agp_is_authenticated()) {
            return;
        }

        http_response_code(401);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => false,
            'message' => 'Sesión expirada. Inicia sesión nuevamente.'
        ]);
        exit;
    }
}

if (!function_exists('agp_login_user')) {
    function agp_login_user(array $userData)
    {
        agp_session_start();
        session_regenerate_id(true);

        $_SESSION['auth'] = true;
        $_SESSION['id'] = $userData['id'];
        $_SESSION['usuario'] = $userData['usuario'];
        $_SESSION['rol'] = $userData['rol'];
        $_SESSION['nombre'] = $userData['nombre'];
        $_SESSION['id_medico'] = isset($userData['id_medico']) ? (int)$userData['id_medico'] : 0;
    }
}

if (!function_exists('agp_current_role')) {
    function agp_current_role()
    {
        agp_session_start();
        return strtolower(trim($_SESSION['rol'] ?? ''));
    }
}

if (!function_exists('agp_has_role')) {
    function agp_has_role($roles)
    {
        $roleActual = agp_current_role();
        $rolesPermitidos = is_array($roles) ? $roles : [$roles];
        $rolesNormalizados = array_map(static function ($item) {
            return strtolower(trim((string)$item));
        }, $rolesPermitidos);

        return in_array($roleActual, $rolesNormalizados, true);
    }
}

if (!function_exists('agp_require_role_json')) {
    function agp_require_role_json($roles)
    {
        if (agp_has_role($roles)) {
            return;
        }

        http_response_code(403);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => false,
            'message' => 'No tienes permisos para ejecutar esta acción.'
        ]);
        exit;
    }
}

if (!function_exists('agp_require_role_page')) {
    function agp_require_role_page($roles)
    {
        if (agp_has_role($roles)) {
            return;
        }

        http_response_code(403);
        echo '<div style="padding:20px"><h4>Acceso denegado</h4><p>No tienes permisos para acceder a esta sección.</p></div>';
        exit;
    }
}

if (!function_exists('agp_logout_user')) {
    function agp_logout_user()
    {
        agp_session_start();
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }
}
?>
