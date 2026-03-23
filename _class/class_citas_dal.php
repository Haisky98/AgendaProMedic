<?php
include_once("class_db.php");

class citas_dal extends class_db
{
    private $serviciosUsanEspecialidad = null;

    public function __construct()
    {
        parent::__construct();
    }
    public function __destruct()
    {
        parent::__destruct();
    }

// CREATE_______________________________________________________________________________________________
    public function create_cita($curp_paciente, $nombre_paciente, $telefono_paciente, $correo_paciente, $id_medico, $id_servicio, $id_hora, $id_estatus, $fecha_cita, $motivo)
    {
        $servicioCompatible = $this->servicio_corresponde_especialidad_medico($id_servicio, $id_medico);
        if ($servicioCompatible === null) {
            return [
                'bool' => false,
                'message' => 'No fue posible validar el servicio seleccionado. Intenta de nuevo.'
            ];
        }

        if (!$servicioCompatible) {
            return [
                'bool' => false,
                'message' => 'El servicio seleccionado no corresponde a la especialidad del médico.'
            ];
        }

        $disponible = $this->hora_disponible($fecha_cita, $id_medico, $id_hora);

        if ($disponible === null) {
            return [
                'bool' => false,
                'message' => 'No fue posible validar la disponibilidad del horario. Intenta de nuevo.'
            ];
        }

        if (!$disponible) {
            return [
                'bool' => false,
                'message' => 'El horario seleccionado ya está ocupado para ese médico y fecha.'
            ];
        }

        $sql = "INSERT INTO citas (curp_paciente, nombre_paciente, telefono_paciente, correo_paciente, id_medico, id_servicio, id_hora, id_estatus, fecha_cita, motivo) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->set_sql($sql);
        $params = [
            $curp_paciente,
            $nombre_paciente,
            $telefono_paciente,
            $correo_paciente,
            $id_medico,
            $id_servicio,
            $id_hora,
            $id_estatus,
            $fecha_cita,
            $motivo
        ];
        
        $resultado = $this->ejecutar_query($params);
        $result = json_decode($resultado, true);

        if (is_array($result) && !empty($result['bool'])) {
            return [
                'bool' => true,
                'id_cita' => isset($result['id_insertado']) ? (int)$result['id_insertado'] : 0
            ];
        }

        return [
            'bool' => false,
            'message' => is_array($result) && isset($result['error']) ? $result['error'] : 'No se pudo registrar la cita.'
        ];
    }
// CREATE_______________________________________________________________________________________________

// READ_______________________________________________________________________________________________
    public function get_cita_detalle($id_cita)
    {
        $sql = "SELECT c.id_cita, c.nombre_paciente, c.correo_paciente, c.telefono_paciente, c.fecha_cita, c.motivo,
                       m.nombre_completo AS medico, s.nombre AS servicio, h.etiqueta AS hora
                FROM citas c
                INNER JOIN medicos m ON c.id_medico = m.id_medico
                INNER JOIN cat_servicios s ON c.id_servicio = s.id_servicio
                INNER JOIN cat_hora_cita h ON c.id_hora = h.id_hora
                WHERE c.id_cita = ?
                LIMIT 1";

        $this->set_sql($sql);
        $json_result = $this->ejecutar_query([(int)$id_cita]);
        $result = json_decode($json_result, true);

        if (!$result['bool'] || empty($result['data'])) {
            return null;
        }

        return $result['data'][0];
    }

    public function read_citas($id_medico = null, $fecha_cita = null)
    {
        $sql = "SELECT c.id_cita, c.nombre_paciente, c.telefono_paciente, c.fecha_cita, c.motivo, 
                       m.nombre_completo AS medico, s.nombre AS servicio, s.costo AS costo_servicio,
                       h.etiqueta AS hora, e.nombre AS estatus
                FROM citas c
                INNER JOIN medicos m ON c.id_medico = m.id_medico
                INNER JOIN cat_servicios s ON c.id_servicio = s.id_servicio
                INNER JOIN cat_hora_cita h ON c.id_hora = h.id_hora
                INNER JOIN cat_estatus_cita e ON c.id_estatus = e.id_estatus";

        $params = [];
        $filtros = [];

        if ($id_medico !== null && (int)$id_medico > 0) {
            $filtros[] = "c.id_medico = ?";
            $params[] = (int)$id_medico;
        }

        if (!empty($fecha_cita) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_cita)) {
            $filtros[] = "c.fecha_cita = ?";
            $params[] = $fecha_cita;
        }

        if (!empty($filtros)) {
            $sql .= " WHERE " . implode(" AND ", $filtros);
        }

        $sql .= " ORDER BY c.fecha_cita DESC, h.hora_inicio ASC";
                
        $this->set_sql($sql);
        $json_result = $this->ejecutar_query($params);

        $result = json_decode($json_result, true);

        if (!$result['bool']) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $lista[] = [
                'id_cita' => $renglon['id_cita'],
                'nombre_paciente' => $renglon['nombre_paciente'],
                'telefono_paciente' => $renglon['telefono_paciente'], // Agregado aquí
                'medico' => $renglon['medico'],
                'servicio' => $renglon['servicio'],
                'costo_servicio' => (float)$renglon['costo_servicio'],
                'hora' => $renglon['hora'],
                'fecha_cita' => $renglon['fecha_cita'],
                'estatus' => $renglon['estatus'],
                'motivo' => $renglon['motivo']
            ];
        }
        return $lista;
    }
// READ_______________________________________________________________________________________________

// UPDATE (Solo Estatus)_______________________________________________________________________________
    public function update_estatus_cita($id_cita, $id_estatus)
    {
        $sql = "UPDATE citas SET id_estatus = ? WHERE id_cita = ?";
        $this->set_sql($sql);
        $params = [
           $id_estatus,
           $id_cita
        ];
        return $this->ejecutar_query($params);
    }
// UPDATE_______________________________________________________________________________________________

// DELETE_______________________________________________________________________________________________
    public function delete_cita($id_cita)
    {
        $sql = "DELETE FROM citas WHERE id_cita = ?";
        $this->set_sql($sql);
        return $this->ejecutar_query([$id_cita]);
    }
// DELETE_______________________________________________________________________________________________

// FUNCIONES ESPECIALES PARA EL FRONTEND (AJAX) _________________________________________________________

    private function servicios_usan_especialidad()
    {
        if ($this->serviciosUsanEspecialidad !== null) {
            return $this->serviciosUsanEspecialidad;
        }

        $this->set_sql("SHOW COLUMNS FROM cat_servicios LIKE 'id_especialidad'");
        $json_result = $this->ejecutar_query();
        $result = json_decode($json_result, true);

        $this->serviciosUsanEspecialidad = is_array($result)
            && !empty($result['bool'])
            && !empty($result['data']);

        return $this->serviciosUsanEspecialidad;
    }

    private function servicio_corresponde_especialidad_medico($id_servicio, $id_medico)
    {
        if (!$this->servicios_usan_especialidad()) {
            return true;
        }

        $sql = "SELECT COUNT(*) AS total
                FROM medicos m
                INNER JOIN cat_servicios s ON s.id_especialidad = m.id_especialidad
                WHERE m.id_medico = ?
                  AND s.id_servicio = ?
                  AND s.activo = 1";

        $this->set_sql($sql);
        $json_result = $this->ejecutar_query([(int)$id_medico, (int)$id_servicio]);
        $result = json_decode($json_result, true);

        if (!$result['bool'] || !isset($result['data'][0]['total'])) {
            return null;
        }

        return ((int)$result['data'][0]['total'] > 0);
    }

    public function get_horas_disponibles($fecha_cita, $id_medico)
    {
        $sql = "SELECT h.id_hora, h.etiqueta 
                FROM cat_hora_cita h
                WHERE h.activo = 1
                  AND NOT EXISTS (
                      SELECT 1
                      FROM citas c
                      INNER JOIN cat_estatus_cita e ON e.id_estatus = c.id_estatus
                      WHERE c.fecha_cita = ?
                        AND c.id_medico = ?
                        AND c.id_hora = h.id_hora
                        AND UPPER(TRIM(e.nombre)) NOT IN ('CANCELADA', 'CANCELADO')
                  )
                ORDER BY h.hora_inicio ASC";
                
        $this->set_sql($sql);
        $params = [$fecha_cita, $id_medico];
        
        $json_result = $this->ejecutar_query($params);
        $result = json_decode($json_result, true);

        if (!$result['bool']) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $lista[] = [
                'id_hora' => $renglon['id_hora'],
                'etiqueta' => $renglon['etiqueta']
            ];
        }
        return $lista;
    }

    public function hora_disponible($fecha_cita, $id_medico, $id_hora)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM citas c
                INNER JOIN cat_estatus_cita e ON e.id_estatus = c.id_estatus
                WHERE c.fecha_cita = ?
                  AND c.id_medico = ?
                  AND c.id_hora = ?
                  AND UPPER(TRIM(e.nombre)) NOT IN ('CANCELADA', 'CANCELADO')";

        $this->set_sql($sql);
        $json_result = $this->ejecutar_query([$fecha_cita, $id_medico, $id_hora]);
        $result = json_decode($json_result, true);

        if (!$result['bool'] || !isset($result['data'][0]['total'])) {
            return null;
        }

        return ((int)$result['data'][0]['total'] === 0);
    }

}
?>
