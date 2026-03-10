<?php
include_once("class_db.php");

class medicos_dal extends class_db
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
    public function create_medico($nombre_completo, $cedula_profesional, $id_especialidad, $id_consultorio, $telefono, $correo, $activo)
    {
        $sql = "INSERT INTO medicos (nombre_completo, cedula_profesional, id_especialidad, id_consultorio, telefono, correo, activo) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $this->set_sql($sql);
        $params = [
            $nombre_completo,
            $cedula_profesional,
            $id_especialidad,
            $id_consultorio,
            $telefono,
            $correo,
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
     public function read_medicos(){
        // Traemos el nombre de la especialidad y consultorio para mostrarlo en tablas
        $sql = "SELECT m.id_medico, m.nombre_completo, m.cedula_profesional, m.id_especialidad, m.id_consultorio, m.telefono, m.correo, m.activo,
                       e.nombre AS especialidad, c.numero_sala AS consultorio
                FROM medicos m
                INNER JOIN cat_especialidades e ON m.id_especialidad = e.id_especialidad
                LEFT JOIN cat_consultorios c ON m.id_consultorio = c.id_consultorio";
                
        $this->set_sql($sql);
        $json_result = $this->ejecutar_query();

        $result = json_decode($json_result, true);

        if (!$result['bool']) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $lista[] = [
                'id_medico' => $renglon['id_medico'],
                'nombre_completo' => $renglon['nombre_completo'],
                'cedula_profesional' => $renglon['cedula_profesional'],
                'id_especialidad' => $renglon['id_especialidad'],
                'id_consultorio' => $renglon['id_consultorio'],
                'especialidad' => $renglon['especialidad'],
                'consultorio' => $renglon['consultorio'],
                'telefono' => $renglon['telefono'],
                'correo' => $renglon['correo'],
                'activo' => $renglon['activo']
            ];
        }
        return $lista;
    }
// READ_______________________________________________________________________________________________

// UPDATE_______________________________________________________________________________________________
    public function update_medico($id_medico, $nombre_completo, $cedula_profesional, $id_especialidad, $id_consultorio, $telefono, $correo, $activo)
    {
        $sql = "UPDATE medicos SET nombre_completo = ?, cedula_profesional = ?, id_especialidad = ?, id_consultorio = ?, telefono = ?, correo = ?, activo = ? 
                WHERE id_medico = ?";
        $this->set_sql($sql);
        $params = [
           $nombre_completo,
           $cedula_profesional,
           $id_especialidad,
           $id_consultorio,
           $telefono,
           $correo,
           $activo,
           $id_medico
        ];
        return $this->ejecutar_query($params);
    }
// UPDATE_______________________________________________________________________________________________

// DELETE_______________________________________________________________________________________________
     public function delete_medico($id_medico)
    {
        $sql = "DELETE FROM medicos WHERE id_medico = ?";
        $this->set_sql($sql);
        return $this->ejecutar_query([$id_medico]);
    }
// DELETE_______________________________________________________________________________________________

// GET PARA EL SELECT DINÁMICO (AJAX) __________________________________________________________________
    // Esta es la función que usamos cuando el usuario selecciona la especialidad en el formulario
    public function get_medicos_por_especialidad($id_especialidad)
    {
        $sql = "SELECT id_medico, nombre_completo 
                FROM medicos 
                WHERE id_especialidad = ? AND activo = 1";
                
        $this->set_sql($sql);
        $json_result = $this->ejecutar_query([$id_especialidad]);

        $result = json_decode($json_result, true);

        if (!$result['bool']) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $lista[] = [
                'id_medico' => $renglon['id_medico'],
                'nombre_completo' => $renglon['nombre_completo']
            ];
        }
        return $lista;
    }
}
?>
