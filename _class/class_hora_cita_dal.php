<?php
include_once("class_db.php");

class hora_cita_dal extends class_db
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
    public function create_hora_cita($hora_inicio, $hora_fin, $etiqueta, $turno, $activo)
    {
        $sql = "INSERT INTO cat_hora_cita (hora_inicio, hora_fin, etiqueta, turno, activo) VALUES (?, ?, ?, ?, ?)";
        $this->set_sql($sql);
        $params = [
            $hora_inicio,
            $hora_fin,
            $etiqueta,
            $turno,
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
     public function read_hora_cita(){
        $sql = "SELECT * FROM cat_hora_cita";
        $this->set_sql($sql);
        $json_result = $this->ejecutar_query();

        $result = json_decode($json_result, true);

        if (!$result['bool']) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $lista[] = [
                'id_hora' => $renglon['id_hora'],
                'hora_inicio' => $renglon['hora_inicio'],
                'hora_fin' => $renglon['hora_fin'],
                'etiqueta' => $renglon['etiqueta'],
                'turno' => $renglon['turno'],
                'activo' => $renglon['activo']
            ];
        }
        return $lista;
    }
// READ_______________________________________________________________________________________________

// UPDATE_______________________________________________________________________________________________
    public function update_hora_cita($id_hora, $hora_inicio, $hora_fin, $etiqueta, $turno, $activo)
    {
        $sql = "UPDATE cat_hora_cita SET hora_inicio = ?, hora_fin = ?, etiqueta = ?, turno = ?, activo = ? WHERE id_hora = ?";
        $this->set_sql($sql);
        $params = [
           $hora_inicio,
           $hora_fin,
           $etiqueta,
           $turno,
           $activo,
           $id_hora
        ];
        return $this->ejecutar_query($params);
    }
// UPDATE_______________________________________________________________________________________________

    public function update_estatus_hora_cita($id_hora, $activo)
    {
        $sql = "UPDATE cat_hora_cita SET activo = ? WHERE id_hora = ?";
        $this->set_sql($sql);
        return $this->ejecutar_query([$activo, $id_hora]);
    }

// DELETE_______________________________________________________________________________________________
     public function delete_hora_cita($id_hora)
    {
        $sql = "DELETE FROM cat_hora_cita WHERE id_hora = ?";
        $this->set_sql($sql);
        return $this->ejecutar_query([$id_hora]);
    }
// DELETE_______________________________________________________________________________________________

    public function get_hora_cita_select()
    {
        $sql = "SELECT * FROM cat_hora_cita WHERE activo = 1 ORDER BY hora_inicio ASC";
        $this->set_sql($sql);
        $json_result = $this->ejecutar_query();

        $result = json_decode($json_result, true);

        if (!$result['bool']) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $lista[] = [
                'id_hora' => $renglon['id_hora'],
                'hora_inicio' => $renglon['hora_inicio'],
                'hora_fin' => $renglon['hora_fin'],
                'etiqueta' => $renglon['etiqueta'],
                'turno' => $renglon['turno'],
                'activo' => $renglon['activo']
            ];
        }
        return $lista;
    }
}
?>
