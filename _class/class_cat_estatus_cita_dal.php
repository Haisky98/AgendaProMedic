<?php
include_once("class_db.php");

class estatus_cita_dal extends class_db
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
    public function create_estatus_cita($nombre, $activo)
    {
        $sql = "INSERT INTO cat_estatus_cita (nombre, activo) VALUES (?, ?)";
        $this->set_sql($sql);
        $params = [
            $nombre,
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
     public function read_estatus_cita(){
        $sql = "SELECT * FROM cat_estatus_cita";
        $this->set_sql($sql);
        $json_result = $this->ejecutar_query();

        $result = json_decode($json_result, true);

        if (!$result['bool']) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $lista[] = [
                'id_estatus' => $renglon['id_estatus'],
                'nombre' => $renglon['nombre'],
                'activo' => $renglon['activo']
            ];
        }
        return $lista;
    }
// READ_______________________________________________________________________________________________

// UPDATE_______________________________________________________________________________________________
    public function update_estatus_cita($id_estatus, $nombre, $activo)
    {
        $sql = "UPDATE cat_estatus_cita SET nombre = ?, activo = ? WHERE id_estatus = ?";
        $this->set_sql($sql);
        $params = [
           $nombre,
           $activo,
           $id_estatus
        ];
        return $this->ejecutar_query($params);
    }
// UPDATE_______________________________________________________________________________________________

// DELETE_______________________________________________________________________________________________
     public function delete_estatus_cita($id_estatus)
    {
        $sql = "DELETE FROM cat_estatus_cita WHERE id_estatus = ?";
        $this->set_sql($sql);
        return $this->ejecutar_query([$id_estatus]);
    }
// DELETE_______________________________________________________________________________________________

    public function get_estatus_cita_select()
    {
        $sql = "SELECT * FROM cat_estatus_cita WHERE activo = 1";
        $this->set_sql($sql);
        $json_result = $this->ejecutar_query();

        $result = json_decode($json_result, true);

        if (!$result['bool']) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $lista[] = [
                'id_estatus' => $renglon['id_estatus'],
                'nombre' => $renglon['nombre'],
                'activo' => $renglon['activo']
            ];
        }
        return $lista;
    }
}
?>
