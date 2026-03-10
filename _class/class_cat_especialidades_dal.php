<?php
include_once("class_db.php");

class especialidades_dal extends class_db
{
    public function __construct()
    {
        parent::__construct();
    }
    public function __destruct()
    {
        parent::__destruct();
    }

// CREATE_______________________________________________________________________________________________
    public function create_especialidad($nombre, $descripcion, $activo)
    {
        $sql = "INSERT INTO cat_especialidades (nombre, descripcion, activo) VALUES (?, ?, ?)";
        $this->set_sql($sql);
        $params = [
            $nombre,
            $descripcion,
            $activo
        ];
        $resultado = $this->ejecutar_query($params);
        if ($resultado) {
            return ['bool' => true];
        } else {
            return ['bool' => false];
        }
    }
// CREATE_______________________________________________________________________________________________

// READ_______________________________________________________________________________________________
     public function read_especialidad(){
        $sql = "SELECT * FROM cat_especialidades";
        $this->set_sql($sql);
        $json_result = $this->ejecutar_query();

        $result = json_decode($json_result, true);

        if (!$result['bool']) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $lista[] = [
                'id_especialidad' => $renglon['id_especialidad'],
                'nombre' => $renglon['nombre'],
                'descripcion' => $renglon['descripcion'],
                'activo' => $renglon['activo']
            ];
        }
        return $lista;
    }
// READ_______________________________________________________________________________________________

// UPDATE_______________________________________________________________________________________________
    public function update_especialidad($id_especialidad, $nombre, $descripcion, $activo)
    {
        $sql = "UPDATE cat_especialidades SET nombre = ?, descripcion = ?, activo = ? WHERE id_especialidad = ?";
        $this->set_sql($sql);
        $params = [
           $nombre,
           $descripcion,
           $activo,
           $id_especialidad
        ];
        return $this->ejecutar_query($params);
    }
// UPDATE_______________________________________________________________________________________________

// DELETE_______________________________________________________________________________________________
     public function delete_especialidad($id_especialidad)
    {
        $sql = "DELETE FROM cat_especialidades WHERE id_especialidad = ?";
        $this->set_sql($sql);
        return $this->ejecutar_query([$id_especialidad]);
    }
// DELETE_______________________________________________________________________________________________

    public function get_especialidades_select()
    {
        $sql = "SELECT * FROM cat_especialidades WHERE activo = 1";
        $this->set_sql($sql);
        $json_result = $this->ejecutar_query();

        $result = json_decode($json_result, true);

        if (!$result['bool']) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $lista[] = [
                'id_especialidad' => $renglon['id_especialidad'],
                'nombre' => $renglon['nombre'],
                'descripcion' => $renglon['descripcion'],
                'activo' => $renglon['activo']
            ];
        }
        return $lista;
    }
}
?>