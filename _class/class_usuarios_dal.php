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

    public function migrar_passwords_legado()
    {
        $cfg = $this->getAuthConfig();
        if (empty($cfg) || empty($cfg['pass_col'])) {
            return ['bool' => false, 'message' => 'No se pudo resolver la tabla de usuarios.'];
        }

        $conn = $this->get_conexion();
        $idKey = !empty($cfg['id_col']) ? $cfg['id_col'] : $cfg['user_col'];
        $idExpr = $this->quoteIdentifier($idKey);
        $passExpr = $this->quoteIdentifier($cfg['pass_col']);
        $tableExpr = $this->quoteIdentifier($cfg['table']);

        $sql = "SELECT $idExpr AS id_ref, $passExpr AS pass_stored
                FROM $tableExpr";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return ['bool' => false, 'message' => 'No se pudo preparar lectura de usuarios para migración.'];
        }

        if (!$stmt->execute()) {
            return ['bool' => false, 'message' => 'No se pudo leer usuarios para migración.'];
        }

        $res = $stmt->get_result();
        if (!$res) {
            return ['bool' => false, 'message' => 'No se pudo obtener resultado para migración.'];
        }

        $migrados = 0;
        while ($row = $res->fetch_assoc()) {
            $passStored = (string)($row['pass_stored'] ?? '');
            if ($passStored === '') {
                continue;
            }

            $passwordInfo = password_get_info($passStored);
            if (!empty($passwordInfo['algo'])) {
                continue;
            }

            $hash = password_hash($passStored, PASSWORD_DEFAULT);
            if ($hash === false) {
                continue;
            }

            $sqlUpdate = "UPDATE $tableExpr
                          SET $passExpr = ?
                          WHERE $idExpr = ?
                          LIMIT 1";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            if (!$stmtUpdate) {
                continue;
            }

            $idRef = (string)$row['id_ref'];
            $stmtUpdate->bind_param("ss", $hash, $idRef);
            if ($stmtUpdate->execute()) {
                $migrados++;
            }
        }

        return ['bool' => true, 'migrados' => $migrados];
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
        if (empty($passwordInfo['algo'])) {
            return null;
        }

        $isValidPassword = password_verify($password, $storedPassword);

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
            return "Las nuevas contraseñas no coinciden.";
        }

        $len = function_exists('mb_strlen') ? mb_strlen((string)$nueva_contrasena, 'UTF-8') : strlen((string)$nueva_contrasena);
        if ($len < 6 || $len > 72) {
            return "La contraseña debe tener entre 6 y 72 caracteres.";
        }

        $user = $this->validar_usuario($usuario, $contrasena_actual);
        if (!$user) {
            return "La contraseña actual es incorrecta o el usuario no existe.";
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
            return "Error al preparar la actualización de contraseña.";
        }

        $stmt->bind_param("ss", $newHash, $usuario);
        if ($stmt->execute()) {
            return "Contraseña actualizada correctamente.";
        }

        return "Error al actualizar la contraseña.";
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
            return ['bool' => false, 'message' => 'Debes capturar usuario, nombre, contraseña y médico.'];
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

        return ['bool' => true, 'message' => 'Usuario médico creado correctamente.'];
    }

    public function update_usuario_medico($id, $usuario, $nombre, $id_medico, $activo = 1, $password = '')
    {
        $cfg = $this->getAuthConfig();
        if (empty($cfg)) {
            return ['bool' => false, 'message' => 'No se pudo resolver la tabla de usuarios.'];
        }

        if (empty($cfg['id_col'])) {
            return ['bool' => false, 'message' => 'La tabla de usuarios no tiene columna ID.'];
        }

        if (empty($cfg['role_col'])) {
            return ['bool' => false, 'message' => 'La tabla de usuarios no tiene columna de rol.'];
        }

        if (empty($cfg['medico_col'])) {
            return ['bool' => false, 'message' => 'La tabla de usuarios no tiene columna id_medico.'];
        }

        $id = (int)$id;
        $usuario = trim($usuario);
        $nombre = trim($nombre);
        $id_medico = (int)$id_medico;
        $activo = (int)$activo;
        $password = (string)$password;

        if ($id <= 0 || $usuario === '' || $nombre === '' || $id_medico <= 0) {
            return ['bool' => false, 'message' => 'Debes capturar id, usuario, nombre y médico.'];
        }

        $conn = $this->get_conexion();

        $sqlActual = "SELECT " . $this->quoteIdentifier($cfg['role_col']) . " AS rol
                      FROM " . $this->quoteIdentifier($cfg['table']) . "
                      WHERE " . $this->quoteIdentifier($cfg['id_col']) . " = ?
                      LIMIT 1";
        $stmtActual = $conn->prepare($sqlActual);
        if (!$stmtActual) {
            return ['bool' => false, 'message' => 'No se pudo validar el usuario a actualizar.'];
        }

        $stmtActual->bind_param("i", $id);
        $stmtActual->execute();
        $resActual = $stmtActual->get_result();
        if (!$resActual || $resActual->num_rows === 0) {
            return ['bool' => false, 'message' => 'El usuario no existe.'];
        }

        $rowActual = $resActual->fetch_assoc();
        $rolActual = strtolower(trim((string)($rowActual['rol'] ?? '')));
        if ($rolActual !== 'medico') {
            return ['bool' => false, 'message' => 'Solo se permite editar usuarios con rol médico.'];
        }

        $sqlExiste = "SELECT 1
                      FROM " . $this->quoteIdentifier($cfg['table']) . "
                      WHERE " . $this->quoteIdentifier($cfg['user_col']) . " = ?
                        AND " . $this->quoteIdentifier($cfg['id_col']) . " <> ?
                      LIMIT 1";
        $stmtExiste = $conn->prepare($sqlExiste);
        if (!$stmtExiste) {
            return ['bool' => false, 'message' => 'No se pudo validar si el usuario ya existe.'];
        }

        $stmtExiste->bind_param("si", $usuario, $id);
        $stmtExiste->execute();
        $resExiste = $stmtExiste->get_result();
        if ($resExiste && $resExiste->num_rows > 0) {
            return ['bool' => false, 'message' => 'El nombre de usuario ya existe.'];
        }

        $setPartes = [];
        $valores = [];
        $tipos = '';

        $setPartes[] = $this->quoteIdentifier($cfg['user_col']) . " = ?";
        $valores[] = $usuario;
        $tipos .= 's';

        if (!empty($cfg['name_col'])) {
            $setPartes[] = $this->quoteIdentifier($cfg['name_col']) . " = ?";
            $valores[] = $nombre;
            $tipos .= 's';
        }

        $setPartes[] = $this->quoteIdentifier($cfg['role_col']) . " = ?";
        $valores[] = 'medico';
        $tipos .= 's';

        $setPartes[] = $this->quoteIdentifier($cfg['medico_col']) . " = ?";
        $valores[] = $id_medico;
        $tipos .= 'i';

        if (!empty($cfg['active_col'])) {
            $setPartes[] = $this->quoteIdentifier($cfg['active_col']) . " = ?";
            $valores[] = $activo;
            $tipos .= 'i';
        }

        if ($password !== '') {
            if (strlen($password) < 6) {
                return ['bool' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres.'];
            }

            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $setPartes[] = $this->quoteIdentifier($cfg['pass_col']) . " = ?";
            $valores[] = $hashPassword;
            $tipos .= 's';
        }

        $sqlUpdate = "UPDATE " . $this->quoteIdentifier($cfg['table']) . "
                      SET " . implode(', ', $setPartes) . "
                      WHERE " . $this->quoteIdentifier($cfg['id_col']) . " = ?";
        $valores[] = $id;
        $tipos .= 'i';

        $stmtUpdate = $conn->prepare($sqlUpdate);
        if (!$stmtUpdate) {
            return ['bool' => false, 'message' => 'No se pudo preparar la actualización del usuario.'];
        }

        $stmtUpdate->bind_param($tipos, ...$valores);
        if (!$stmtUpdate->execute()) {
            return ['bool' => false, 'message' => 'Error al actualizar usuario: ' . $stmtUpdate->error];
        }

        return ['bool' => true, 'message' => 'Usuario actualizado correctamente.'];
    }

    public function delete_usuario_medico($id, $idUsuarioActual = 0)
    {
        $cfg = $this->getAuthConfig();
        if (empty($cfg)) {
            return ['bool' => false, 'message' => 'No se pudo resolver la tabla de usuarios.'];
        }

        if (empty($cfg['id_col'])) {
            return ['bool' => false, 'message' => 'La tabla de usuarios no tiene columna ID.'];
        }

        if (empty($cfg['role_col'])) {
            return ['bool' => false, 'message' => 'La tabla de usuarios no tiene columna de rol.'];
        }

        $id = (int)$id;
        $idUsuarioActual = (int)$idUsuarioActual;

        if ($id <= 0) {
            return ['bool' => false, 'message' => 'ID de usuario inválido.'];
        }

        if ($idUsuarioActual > 0 && $id === $idUsuarioActual) {
            return ['bool' => false, 'message' => 'No puedes eliminar tu propio usuario en sesión.'];
        }

        $conn = $this->get_conexion();

        $sqlActual = "SELECT " . $this->quoteIdentifier($cfg['role_col']) . " AS rol
                      FROM " . $this->quoteIdentifier($cfg['table']) . "
                      WHERE " . $this->quoteIdentifier($cfg['id_col']) . " = ?
                      LIMIT 1";
        $stmtActual = $conn->prepare($sqlActual);
        if (!$stmtActual) {
            return ['bool' => false, 'message' => 'No se pudo validar el usuario a eliminar.'];
        }

        $stmtActual->bind_param("i", $id);
        $stmtActual->execute();
        $resActual = $stmtActual->get_result();
        if (!$resActual || $resActual->num_rows === 0) {
            return ['bool' => false, 'message' => 'El usuario no existe.'];
        }

        $rowActual = $resActual->fetch_assoc();
        $rolActual = strtolower(trim((string)($rowActual['rol'] ?? '')));
        if ($rolActual !== 'medico') {
            return ['bool' => false, 'message' => 'Solo se permite eliminar usuarios con rol médico.'];
        }

        $sqlDelete = "DELETE FROM " . $this->quoteIdentifier($cfg['table']) . "
                      WHERE " . $this->quoteIdentifier($cfg['id_col']) . " = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        if (!$stmtDelete) {
            return ['bool' => false, 'message' => 'No se pudo preparar la eliminación del usuario.'];
        }

        $stmtDelete->bind_param("i", $id);
        if (!$stmtDelete->execute()) {
            return ['bool' => false, 'message' => 'Error al eliminar usuario: ' . $stmtDelete->error];
        }

        if ($stmtDelete->affected_rows <= 0) {
            return ['bool' => false, 'message' => 'No se eliminó ningún usuario.'];
        }

        return ['bool' => true, 'message' => 'Usuario eliminado correctamente.'];
    }
}
?>
