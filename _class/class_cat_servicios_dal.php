<?php
include_once("class_db.php");

class servicios_dal extends class_db
{
    private $tieneRelacionEspecialidad = null;

    public function __construct()
    {
        parent::__construct();
    }
    public function __destruct()
    {
        parent::__destruct();
    }

// CREATE_______________________________________________________________________________________________
    public function create_servicio($id_especialidad, $nombre, $duracion_estimada_minutos, $costo, $activo)
    {
        if ($this->tiene_relacion_especialidad()) {
            $sql = "INSERT INTO cat_servicios (id_especialidad, nombre, duracion_estimada_minutos, costo, activo) VALUES (?, ?, ?, ?, ?)";
            $this->set_sql($sql);
            $params = [
                $id_especialidad,
                $nombre,
                $duracion_estimada_minutos,
                $costo,
                $activo
            ];
        } else {
            $sql = "INSERT INTO cat_servicios (nombre, duracion_estimada_minutos, costo, activo) VALUES (?, ?, ?, ?)";
            $this->set_sql($sql);
            $params = [
                $nombre,
                $duracion_estimada_minutos,
                $costo,
                $activo
            ];
        }

        $resultado = $this->ejecutar_query($params);
        if ($resultado) {
            return ['bool' => true];
        } else {
            return ['bool' => false];
        }
    }
// CREATE_______________________________________________________________________________________________

// READ_______________________________________________________________________________________________
     public function read_servicio(){
        if ($this->tiene_relacion_especialidad()) {
            $sql = "SELECT s.id_servicio, s.id_especialidad, s.nombre, s.duracion_estimada_minutos, s.costo, s.activo,
                           e.nombre AS nombre_especialidad
                    FROM cat_servicios s
                    LEFT JOIN cat_especialidades e ON e.id_especialidad = s.id_especialidad
                    ORDER BY s.nombre ASC";
        } else {
            $sql = "SELECT id_servicio, nombre, duracion_estimada_minutos, costo, activo
                    FROM cat_servicios
                    ORDER BY nombre ASC";
        }

        $this->set_sql($sql);
        $json_result = $this->ejecutar_query();

        $result = json_decode($json_result, true);

        if (!$result['bool']) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $lista[] = [
                'id_servicio' => $renglon['id_servicio'],
                'id_especialidad' => isset($renglon['id_especialidad']) ? (int)$renglon['id_especialidad'] : 0,
                'nombre_especialidad' => isset($renglon['nombre_especialidad']) ? $renglon['nombre_especialidad'] : 'Sin asignar',
                'nombre' => $renglon['nombre'],
                'duracion_estimada_minutos' => $renglon['duracion_estimada_minutos'],
                'costo' => $renglon['costo'],
                'activo' => $renglon['activo']
            ];
        }
        return $lista;
    }
// READ_______________________________________________________________________________________________

// UPDATE_______________________________________________________________________________________________
    public function update_servicio($id_servicio, $id_especialidad, $nombre, $duracion_estimada_minutos, $costo, $activo)
    {
        if ($this->tiene_relacion_especialidad()) {
            $sql = "UPDATE cat_servicios
                    SET id_especialidad = ?, nombre = ?, duracion_estimada_minutos = ?, costo = ?, activo = ?
                    WHERE id_servicio = ?";
            $this->set_sql($sql);
            $params = [
                $id_especialidad,
                $nombre,
                $duracion_estimada_minutos,
                $costo,
                $activo,
                $id_servicio
            ];
        } else {
            $sql = "UPDATE cat_servicios SET nombre = ?, duracion_estimada_minutos = ?, costo = ?, activo = ? WHERE id_servicio = ?";
            $this->set_sql($sql);
            $params = [
                $nombre,
                $duracion_estimada_minutos,
                $costo,
                $activo,
                $id_servicio
            ];
        }

        return $this->ejecutar_query($params);
    }
// UPDATE_______________________________________________________________________________________________

// DELETE_______________________________________________________________________________________________
     public function delete_servicio($id_servicio)
    {
        $sql = "DELETE FROM cat_servicios WHERE id_servicio = ?";
        $this->set_sql($sql);
        return $this->ejecutar_query([$id_servicio]);
    }
// DELETE_______________________________________________________________________________________________

    public function get_servicios_select($id_especialidad = null)
    {
        $params = [];

        if ($this->tiene_relacion_especialidad()) {
            $sql = "SELECT s.id_servicio, s.id_especialidad, s.nombre, s.duracion_estimada_minutos, s.costo, s.activo,
                           e.nombre AS nombre_especialidad
                    FROM cat_servicios s
                    LEFT JOIN cat_especialidades e ON e.id_especialidad = s.id_especialidad
                    WHERE s.activo = 1";

            if ($id_especialidad !== null && (int)$id_especialidad > 0) {
                $sql .= " AND s.id_especialidad = ?";
                $params[] = (int)$id_especialidad;
            }

            $sql .= " ORDER BY s.nombre ASC";
        } else {
            $sql = "SELECT id_servicio, nombre, duracion_estimada_minutos, costo, activo
                    FROM cat_servicios
                    WHERE activo = 1
                    ORDER BY nombre ASC";
        }

        $this->set_sql($sql);
        $json_result = $this->ejecutar_query($params);

        $result = json_decode($json_result, true);

        if (!$result['bool']) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $lista[] = [
                'id_servicio' => $renglon['id_servicio'],
                'id_especialidad' => isset($renglon['id_especialidad']) ? (int)$renglon['id_especialidad'] : 0,
                'nombre_especialidad' => isset($renglon['nombre_especialidad']) ? $renglon['nombre_especialidad'] : 'Sin asignar',
                'nombre' => $renglon['nombre'],
                'duracion_estimada_minutos' => $renglon['duracion_estimada_minutos'],
                'costo' => $renglon['costo'],
                'activo' => $renglon['activo']
            ];
        }
        return $lista;
    }

    private function tiene_relacion_especialidad()
    {
        if ($this->tieneRelacionEspecialidad !== null) {
            return $this->tieneRelacionEspecialidad;
        }

        $this->set_sql("SHOW COLUMNS FROM cat_servicios LIKE 'id_especialidad'");
        $json_result = $this->ejecutar_query();
        $result = json_decode($json_result, true);

        $this->tieneRelacionEspecialidad = is_array($result)
            && !empty($result['bool'])
            && !empty($result['data']);

        return $this->tieneRelacionEspecialidad;
    }
}
?>
