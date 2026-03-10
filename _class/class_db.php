<?php
date_default_timezone_set('America/Mexico_City');
if(class_exists('class_db') != true)
{
    class class_db
    {
        public $db_conn;
        public $db_name;
        public $db_query;
        //Base de Datos
        public function __construct()
        {
            // Si la IP es local 
            if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
                $this->set_db("localhost", "root", "", "agendapromedic");
            } else {
                // Si el codigo ya esta subido en InfinityFree
                $this->set_db(
                    "sql306.infinityfree.com",
                    "if0_41208824",            
                    "fCThFtgiyFTo",       
                    "if0_41208824_agendapromedic"
                ); 
            }
        }

        public function __destruct()
        {
            $this->close_db();
        }

        public function set_db($host, $user, $passwd, $db)
        {
            if (!isset($this->db_conn)) {
                $this->db_conn = mysqli_connect($host, $user, $passwd, $db);
                $this->db_name = $db;
                $this->db_conn->set_charset("utf8");
                //$this->db_conn->set_charset("latin1");
            }
        }

        public function close_db()
        {
            if (isset($this->db_conn)) {
                mysqli_kill($this->db_conn,$this->db_conn->thread_id);
                mysqli_close($this->db_conn);
            }
        }

        public function set_sql($sql)
        {
            $this->db_query = $sql;
        }

            public function ejecutar_query($params = [])
    {
        if (!$this->db_conn) {
            return json_encode([
                "bool" => false,
                "error" => "No hay conexión a la base de datos."
            ]);
        }

        mysqli_set_charset($this->db_conn, "utf8mb4"); // Asegurar codificación correcta

        // Verificar si es una consulta preparada
        if (preg_match('/^\s*(INSERT|UPDATE|DELETE|SELECT|SHOW|DESCRIBE|EXPLAIN)\s/i', $this->db_query)) {

            // Preparar la consulta y evitar SQL injection
            $stmt = $this->db_conn->prepare($this->db_query);

            if ($stmt === false) {
                return json_encode([
                    "bool" => false,
                    "error" => "Error al preparar la consulta: " . mysqli_error($this->db_conn)
                ]);
            }

            // Verifica que $params no esté vacío antes de bind_param
            if (!empty($params)) {
                $tipos = str_repeat("s", count($params)); // Asumimos que todos los valores son strings
                $stmt->bind_param($tipos, ...$params);
            } /* solo descomentar este else en dado caso que no se pase no este pasando ningun parametro si se quita el comentario no va a permitir ejecutar 
            la consulta SELECT 
            else {
                return json_encode([
                    "bool" => false,
                    "error" => "No se proporcionaron parámetros para la consulta."
                ]);
            }*/

            // Ejecutar la consulta
            if (!$stmt->execute()) {
                return json_encode([
                    "bool" => false,
                    "error" => "Error al ejecutar consulta: " . $stmt->error
                ]);
            }

            // Para los casos de INSERT
            if (preg_match('/^\s*INSERT\s/i', $this->db_query)) {
                return json_encode([
                    "bool" => true,
                    "id_insertado" => $this->db_conn->insert_id // Obtener el ID de inserción
                ]);
            }

            // Para UPDATE y DELETE
            if (preg_match('/^\s*(UPDATE|DELETE)\s/i', $this->db_query)) {
                return json_encode([
                    "bool" => true,
                    "filas_afectadas" => $stmt->affected_rows // Número de filas afectadas
                ]);
            }

            // Para SELECT, SHOW, DESCRIBE, EXPLAIN
            if (preg_match('/^\s*(SELECT|SHOW|DESCRIBE|EXPLAIN)\s/i', $this->db_query)) {
                $result = $stmt->get_result();
                $data = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
                return json_encode([
                    "bool" => true,
                    "data" => $data
                ], JSON_UNESCAPED_UNICODE); //elemental para caracteres especiales
            }

            return json_encode(["bool" => true]);
        }

        return json_encode([
            "bool" => false,
            "error" => "Consulta no válida"
        ]);
    }

        public function throw_ex($error){
            throw new Exception($error);
        }

        public function iniciar_transaccion(){
            mysqli_begin_transaction($this->db_conn);
        }

        public function commit(){
            mysqli_commit($this->db_conn);
        }

        public function rollback(){
            mysqli_rollback($this->db_conn);
        }
        public function get_conexion() {
            return $this->db_conn;
        }

    }
}
?>