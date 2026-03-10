<?php
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/../_class/class_reportes_dal.php';

header('Content-Type: application/json; charset=utf-8');

$fechaInicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : date('Y-m-01');
$fechaFin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : date('Y-m-d');
$agruparPor = isset($_POST['agrupar_por']) ? $_POST['agrupar_por'] : 'servicio';

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaInicio) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fechaFin)) {
    echo json_encode([
        'success' => false,
        'message' => 'Formato de fechas inválido.'
    ]);
    exit;
}

if ($fechaInicio > $fechaFin) {
    $tmp = $fechaInicio;
    $fechaInicio = $fechaFin;
    $fechaFin = $tmp;
}

$reportes = new reportes_dal();
$data = $reportes->get_productividad($fechaInicio, $fechaFin, $agruparPor);

$totalCitas = 0;
$totalIngresos = 0.0;
foreach ($data as $row) {
    $totalCitas += (int)$row['total_citas'];
    $totalIngresos += (float)$row['ingresos_totales'];
}

echo json_encode([
    'success' => true,
    'data' => $data,
    'resumen' => [
        'total_citas' => $totalCitas,
        'total_ingresos' => round($totalIngresos, 2)
    ],
    'filtros' => [
        'fecha_inicio' => $fechaInicio,
        'fecha_fin' => $fechaFin,
        'agrupar_por' => ($agruparPor === 'medico' ? 'medico' : 'servicio')
    ]
], JSON_UNESCAPED_UNICODE);
?>
