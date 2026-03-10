<?php
include_once("class_db.php");

class consultorios_dal extends class_db
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
    public function create_consultorio($numero_sala, $ubicacion, $activo)
    {
        $sql = "INSERT INTO cat_consultorios (numero_sala, ubicacion, activo) VALUES (?, ?, ?)";
        $this->set_sql($sql);
        $params = [
            $numero_sala,
            $ubicacion,
            $activo
        ];
        $resultado_json = $this->ejecutar_query($params);
        $resultado = json_decode($resultado_json, true);
        return [
            'bool' => !empty($resultado['bool']),
            'error' => $resultado['error'] ?? null
        ];
    }
// CREATE_______________________________________________________________________________________________


// READ_______________________________________________________________________________________________
     public function read_consultorio(){
        $sql = "SELECT * FROM cat_consultorios";
        $this->set_sql($sql);
        $json_result = $this->ejecutar_query();

        $result = json_decode($json_result, true);

        if (!$result['bool']) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $lista[] = [
                'id_consultorio' => $renglon['id_consultorio'],
                'numero_sala' => $renglon['numero_sala'],
                'ubicacion' => $renglon['ubicacion'],
                'activo' => $renglon['activo']
            ];
        }
        return $lista;
    }

// READ_______________________________________________________________________________________________


// UPDATE_______________________________________________________________________________________________
    public function update_consultorio($id_consultorio, $numero_sala, $ubicacion, $activo)
    {
        $sql = "UPDATE cat_consultorios SET numero_sala = ?, ubicacion = ?, activo = ? WHERE id_consultorio = ?";
        $this->set_sql($sql);
        $params = [
           $numero_sala,
           $ubicacion,
           $activo,
           $id_consultorio
        ];
        return $this->ejecutar_query($params);
    }

// UPDATE_______________________________________________________________________________________________

    public function update_estatus_consultorio($id_consultorio, $activo)
    {
        $sql = "UPDATE cat_consultorios SET activo = ? WHERE id_consultorio = ?";
        $this->set_sql($sql);
        return $this->ejecutar_query([$activo, $id_consultorio]);
    }

// DELETE_______________________________________________________________________________________________

     public function delete_consultorio($id_consultorio)
    {
        $sql = "DELETE FROM cat_consultorios WHERE id_consultorio = ?";
        $this->set_sql($sql);
        return $this->ejecutar_query([$id_consultorio]);
    }

// DELETE_______________________________________________________________________________________________


    public function get_consultorios_select()
    {
        $sql = "SELECT * FROM cat_consultorios WHERE activo = 1";
        $this->set_sql($sql);
        $json_result = $this->ejecutar_query();

        $result = json_decode($json_result, true);

        if (!$result['bool']) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $lista[] = [
                'id_consultorio' => $renglon['id_consultorio'],
                'numero_sala' => $renglon['numero_sala'],
                'ubicacion' => $renglon['ubicacion'],
                'activo' => $renglon['activo']
            ];
        }
        return $lista;
    }


}
