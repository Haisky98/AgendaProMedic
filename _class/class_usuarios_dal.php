<?php
include("class_db.php");

class class_usuario_dal extends class_db
{
    private $authConfig = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    private function quoteIdentifier($name)
    {
        return '`' . str_replace('`', '``', $name) . '`';
    }

    private function tableExists($tableName)
    {
        $conn = $this->get_conexion();
        try {
            $sql = "SELECT 1
                    FROM information_schema.tables
                    WHERE table_schema = DATABASE()
                      AND table_name = ?
                    LIMIT 1";

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                return false;
            }

            $stmt->bind_param("s", $tableName);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result && $result->num_rows > 0;
        } catch (mysqli_sql_exception $e) {
            $tableEscaped = $conn->real_escape_string($tableName);
            $query = $conn->query("SHOW TABLES LIKE '{$tableEscaped}'");
            return $query && $query->num_rows > 0;
        }
    }

    private function getColumns($tableName)
    {
        $conn = $this->get_conexion();
        $sql = "SHOW COLUMNS FROM " . $this->quoteIdentifier($tableName);
        $query = $conn->query($sql);
        $columns = [];

        if ($query) {
            while ($row = $query->fetch_assoc()) {
                $columns[strtolower($row['Field'])] = true;
            }
        }

        return $columns;
    }

    private function pickColumn(array $columns, array $candidates)
    {
        foreach ($candidates as $candidate) {
            if (isset($columns[strtolower($candidate)])) {
                return $candidate;
            }
        }
        return null;
    }

    private function getAuthConfig()
    {
        if ($this->authConfig !== null) {
            return $this->authConfig;
        }

        $tables = ['usuarios', 'usuario'];
        $credentials = [
            ['usuario', 'password'],
            ['usuario', 'pwd'],
            ['user', 'password'],
            ['user', 'pwd']
        ];

        foreach ($tables as $table) {
            if (!$this->tableExists($table)) {
                continue;
            }

            $columns = $this->getColumns($table);
            foreach ($credentials as $pair) {
                if (isset($columns[$pair[0]]) && isset($columns[$pair[1]])) {
                    $this->authConfig = [
                        'table' => $table,
                        'user_col' => $pair[0],
                        'pass_col' => $pair[1],
                        'id_col' => $this->pickColumn($columns, ['id', 'id_usuario', 'id_user']),
                        'name_col' => $this->pickColumn($columns, ['nombre', 'nombre_completo']),
                        'role_col' => $this->pickColumn($columns, ['rol', 'perfil']),
                        'active_col' => $this->pickColumn($columns, ['activo', 'estatus']),
                        'medico_col' => $this->pickColumn($columns, ['id_medico', 'id_doctor'])
                    ];
                    return $this->authConfig;
                }
            }
        }

        $this->authConfig = [];
        return $this->authConfig;
    }

    public function validar_usuario($usuario, $password)
    {
        $conn = $this->get_conexion();
        $cfg = $this->getAuthConfig();
        if (empty($cfg)) {
            return null;
        }

        $idExpr = $cfg['id_col'] ? $this->quoteIdentifier($cfg['id_col']) : "0";
        $nameExpr = $cfg['name_col'] ? $this->quoteIdentifier($cfg['name_col']) : "'Usuario'";
        $roleExpr = $cfg['role_col'] ? $this->quoteIdentifier($cfg['role_col']) : "'admin'";
        $activeExpr = $cfg['active_col'] ? $this->quoteIdentifier($cfg['active_col']) : "1";
        $medicoExpr = $cfg['medico_col'] ? $this->quoteIdentifier($cfg['medico_col']) : "0";

        $sql = "SELECT $idExpr AS id, $nameExpr AS nombre, $roleExpr AS rol, $activeExpr AS activo, $medicoExpr AS id_medico, " .
            $this->quoteIdentifier($cfg['pass_col']) . " AS pass_stored " .
            "FROM " . $this->quoteIdentifier($cfg['table']) . " " .
            "WHERE " . $this->quoteIdentifier($cfg['user_col']) . " = ? LIMIT 1";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if (!$resultado || $resultado->num_rows !== 1) {
            return null;
        }

        $row = $resultado->fetch_assoc();
        if (isset($row['activo']) && (int)$row['activo'] !== 1) {
            return null;
        }

        $storedPassword = (string)$row['pass_stored'];
        $passwordInfo = password_get_info($storedPassword);

        if (!empty($passwordInfo['algo'])) {
            $isValidPassword = password_verify($password, $storedPassword);
        } else {
            $isValidPassword = hash_equals($storedPassword, $password);
        }

        if (!$isValidPassword) {
            return null;
        }

        return [
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'rol' => $row['rol'],
            'usuario' => $usuario,
            'id_medico' => isset($row['id_medico']) ? (int)$row['id_medico'] : 0
        ];
    }

    public function actualizar_contrasena($usuario, $contrasena_actual, $nueva_contrasena, $confirmacion_contrasena)
    {
        if ($nueva_contrasena !== $confirmacion_contrasena) {
            return "Las nuevas contrasenas no coinciden.";
        }

        $user = $this->validar_usuario($usuario, $contrasena_actual);
        if (!$user) {
            return "La contrasena actual es incorrecta o el usuario no existe.";
        }

        $cfg = $this->getAuthConfig();
        if (empty($cfg)) {
            return "No se pudo resolver la tabla de usuarios.";
        }

        $conn = $this->get_conexion();
        $newHash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        $sql = "UPDATE " . $this->quoteIdentifier($cfg['table']) . " SET " .
            $this->quoteIdentifier($cfg['pass_col']) . " = ? WHERE " .
            $this->quoteIdentifier($cfg['user_col']) . " = ?";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return "Error al preparar la actualizacion de contrasena.";
        }

        $stmt->bind_param("ss", $newHash, $usuario);
        if ($stmt->execute()) {
            return "Contrasena actualizada correctamente.";
        }

        return "Error al actualizar la contrasena.";
    }

    public function listar_usuarios()
    {
        $cfg = $this->getAuthConfig();
        if (empty($cfg)) {
            return [];
        }

        $idExpr = $cfg['id_col'] ? 'u.' . $this->quoteIdentifier($cfg['id_col']) : "0";
        $userExpr = 'u.' . $this->quoteIdentifier($cfg['user_col']);
        $nameExpr = $cfg['name_col'] ? 'u.' . $this->quoteIdentifier($cfg['name_col']) : "'Usuario'";
        $roleExpr = $cfg['role_col'] ? 'u.' . $this->quoteIdentifier($cfg['role_col']) : "'admin'";
        $activeExpr = $cfg['active_col'] ? 'u.' . $this->quoteIdentifier($cfg['active_col']) : "1";

        $medicoExpr = "0";
        $medicoNombreExpr = "''";
        $joinMedico = "";

        if (!empty($cfg['medico_col'])) {
            $medicoExpr = 'u.' . $this->quoteIdentifier($cfg['medico_col']);
            $medicoNombreExpr = "COALESCE(m.nombre_completo, '')";
            $joinMedico = " LEFT JOIN medicos m ON m.id_medico = $medicoExpr ";
        }

        $sql = "SELECT $idExpr AS id,
                       $userExpr AS usuario,
                       $nameExpr AS nombre,
                       $roleExpr AS rol,
                       $activeExpr AS activo,
                       $medicoExpr AS id_medico,
                       $medicoNombreExpr AS medico_nombre
                FROM " . $this->quoteIdentifier($cfg['table']) . " u
                $joinMedico
                ORDER BY id DESC";

        $this->set_sql($sql);
        $json_result = $this->ejecutar_query();
        $result = json_decode($json_result, true);

        if (empty($result['bool'])) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $row) {
            $lista[] = [
                'id' => (int)$row['id'],
                'usuario' => $row['usuario'],
                'nombre' => $row['nombre'],
                'rol' => strtolower((string)$row['rol']),
                'activo' => (int)$row['activo'],
                'id_medico' => isset($row['id_medico']) ? (int)$row['id_medico'] : 0,
                'medico_nombre' => $row['medico_nombre'] ?? ''
            ];
        }

        return $lista;
    }

    public function get_medicos_activos()
    {
        $sql = "SELECT id_medico, nombre_completo
                FROM medicos
                WHERE activo = 1
                ORDER BY nombre_completo ASC";

        $this->set_sql($sql);
        $json_result = $this->ejecutar_query();
        $result = json_decode($json_result, true);

        if (empty($result['bool'])) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $row) {
            $lista[] = [
                'id_medico' => (int)$row['id_medico'],
                'nombre_completo' => $row['nombre_completo']
            ];
        }

        return $lista;
    }

    public function create_usuario_medico($usuario, $password, $nombre, $id_medico, $activo = 1)
    {
        $cfg = $this->getAuthConfig();
        if (empty($cfg)) {
            return ['bool' => false, 'message' => 'No se pudo resolver la tabla de usuarios.'];
        }

        if (empty($cfg['role_col'])) {
            return ['bool' => false, 'message' => 'La tabla de usuarios no tiene columna de rol.'];
        }

        if (empty($cfg['medico_col'])) {
            return ['bool' => false, 'message' => 'La tabla de usuarios no tiene columna id_medico.'];
        }

        $usuario = trim($usuario);
        $nombre = trim($nombre);
        $id_medico = (int)$id_medico;
        $activo = (int)$activo;

        if ($usuario === '' || $password === '' || $nombre === '' || $id_medico <= 0) {
            return ['bool' => false, 'message' => 'Debes capturar usuario, nombre, contrasena y medico.'];
        }

        $conn = $this->get_conexion();

        $sqlExiste = "SELECT 1
                      FROM " . $this->quoteIdentifier($cfg['table']) . "
                      WHERE " . $this->quoteIdentifier($cfg['user_col']) . " = ?
                      LIMIT 1";
        $stmtExiste = $conn->prepare($sqlExiste);
        if (!$stmtExiste) {
            return ['bool' => false, 'message' => 'No se pudo validar si el usuario ya existe.'];
        }
        $stmtExiste->bind_param("s", $usuario);
        $stmtExiste->execute();
        $resExiste = $stmtExiste->get_result();
        if ($resExiste && $resExiste->num_rows > 0) {
            return ['bool' => false, 'message' => 'El nombre de usuario ya existe.'];
        }

        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $columnas = [
            $this->quoteIdentifier($cfg['user_col']),
            $this->quoteIdentifier($cfg['pass_col']),
            $this->quoteIdentifier($cfg['role_col']),
            $this->quoteIdentifier($cfg['medico_col'])
        ];
        $valores = [$usuario, $hashPassword, 'medico', $id_medico];
        $tipos = "sssi";

        if (!empty($cfg['name_col'])) {
            $columnas[] = $this->quoteIdentifier($cfg['name_col']);
            $valores[] = $nombre;
            $tipos .= "s";
        }

        if (!empty($cfg['active_col'])) {
            $columnas[] = $this->quoteIdentifier($cfg['active_col']);
            $valores[] = $activo;
            $tipos .= "i";
        }

        $placeholders = implode(', ', array_fill(0, count($columnas), '?'));
        $sqlInsert = "INSERT INTO " . $this->quoteIdentifier($cfg['table']) .
            " (" . implode(', ', $columnas) . ") VALUES ($placeholders)";

        $stmtInsert = $conn->prepare($sqlInsert);
        if (!$stmtInsert) {
            return ['bool' => false, 'message' => 'No se pudo preparar el alta del usuario.'];
        }

        $stmtInsert->bind_param($tipos, ...$valores);
        if (!$stmtInsert->execute()) {
            return ['bool' => false, 'message' => 'Error al guardar usuario: ' . $stmtInsert->error];
        }

        return ['bool' => true, 'message' => 'Usuario medico creado correctamente.'];
    }
}
?>
