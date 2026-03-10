<?php
require_once("class_db.php");

class dashboard_dal extends class_db
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    private function firstValue($sql, $params = [])
    {
        $this->set_sql($sql);
        $json = $this->ejecutar_query($params);
        $result = json_decode($json, true);
        if (empty($result['bool']) || empty($result['data'][0])) {
            return 0;
        }

        $row = $result['data'][0];
        $firstKey = array_key_first($row);
        return $row[$firstKey] ?? 0;
    }

    public function get_resumen_hoy()
    {
        $totalCitasHoy = (int)$this->firstValue("
            SELECT COUNT(*) AS total
            FROM citas
            WHERE fecha_cita = CURDATE()
        ");

        $ingresosHoy = (float)$this->firstValue("
            SELECT COALESCE(SUM(s.costo), 0) AS total
            FROM citas c
            INNER JOIN cat_servicios s ON c.id_servicio = s.id_servicio
            INNER JOIN cat_estatus_cita e ON c.id_estatus = e.id_estatus
            WHERE c.fecha_cita = CURDATE()
              AND LOWER(TRIM(e.nombre)) = 'finalizada'
        ");

        $pendientesConfirmacion = (int)$this->firstValue("
            SELECT COUNT(*) AS total
            FROM citas c
            INNER JOIN cat_estatus_cita e ON c.id_estatus = e.id_estatus
            WHERE c.fecha_cita >= CURDATE()
              AND LOWER(TRIM(e.nombre)) LIKE 'pendiente%'
        ");

        return [
            'total_citas_hoy' => $totalCitasHoy,
            'ingresos_hoy' => $ingresosHoy,
            'pendientes_confirmacion' => $pendientesConfirmacion
        ];
    }

    public function get_top_medicos_hoy($limit = 5)
    {
        $limit = max(1, min((int)$limit, 10));
        $sql = "
            SELECT m.nombre_completo AS medico, COUNT(*) AS total_citas
            FROM citas c
            INNER JOIN medicos m ON c.id_medico = m.id_medico
            WHERE c.fecha_cita = CURDATE()
            GROUP BY c.id_medico, m.nombre_completo
            ORDER BY total_citas DESC, m.nombre_completo ASC
            LIMIT $limit
        ";

        $this->set_sql($sql);
        $json = $this->ejecutar_query();
        $result = json_decode($json, true);
        if (empty($result['bool'])) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $row) {
            $lista[] = [
                'medico' => $row['medico'],
                'total_citas' => (int)$row['total_citas']
            ];
        }
        return $lista;
    }
}
?>
