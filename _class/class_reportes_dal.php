<?php
require_once("class_db.php");

class reportes_dal extends class_db
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    public function get_productividad($fechaInicio, $fechaFin, $agruparPor = 'servicio')
    {
        $agruparPor = strtolower(trim($agruparPor));
        if ($agruparPor !== 'medico') {
            $agruparPor = 'servicio';
        }

        if ($agruparPor === 'medico') {
            $sql = "
                SELECT 
                    m.id_medico AS id_referencia,
                    m.nombre_completo AS concepto,
                    COUNT(c.id_cita) AS total_citas,
                    COALESCE(SUM(s.costo), 0) AS ingresos_totales
                FROM citas c
                INNER JOIN medicos m ON c.id_medico = m.id_medico
                INNER JOIN cat_servicios s ON c.id_servicio = s.id_servicio
                INNER JOIN cat_estatus_cita e ON c.id_estatus = e.id_estatus
                WHERE c.fecha_cita BETWEEN ? AND ?
                  AND LOWER(TRIM(e.nombre)) = 'finalizada'
                GROUP BY m.id_medico, m.nombre_completo
                ORDER BY ingresos_totales DESC, total_citas DESC
            ";
        } else {
            $sql = "
                SELECT 
                    s.id_servicio AS id_referencia,
                    s.nombre AS concepto,
                    COUNT(c.id_cita) AS total_citas,
                    COALESCE(SUM(s.costo), 0) AS ingresos_totales
                FROM citas c
                INNER JOIN cat_servicios s ON c.id_servicio = s.id_servicio
                INNER JOIN cat_estatus_cita e ON c.id_estatus = e.id_estatus
                WHERE c.fecha_cita BETWEEN ? AND ?
                  AND LOWER(TRIM(e.nombre)) = 'finalizada'
                GROUP BY s.id_servicio, s.nombre
                ORDER BY ingresos_totales DESC, total_citas DESC
            ";
        }

        $this->set_sql($sql);
        $json = $this->ejecutar_query([$fechaInicio, $fechaFin]);
        $result = json_decode($json, true);

        if (empty($result['bool'])) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $row) {
            $lista[] = [
                'id_referencia' => $row['id_referencia'],
                'concepto' => $row['concepto'],
                'total_citas' => (int)$row['total_citas'],
                'ingresos_totales' => (float)$row['ingresos_totales']
            ];
        }
        return $lista;
    }
}
?>
