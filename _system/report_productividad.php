<?php
require_once __DIR__ . '/auth_guard.php';
$hoy = date('Y-m-d');
$inicioMes = date('Y-m-01');
?>

<style>
    /* ===== ESTILOS MODERNOS (mismo diseño que el dashboard) ===== */
    .dashboard-container {
        padding: 24px;
        max-width: 1400px;
        margin: 0 auto;
        animation: fadeIn 0.3s ease-out;
    }

    .page-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        gap: 16px;
    }

    .header-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-title i {
        font-size: 2.2rem;
        background: linear-gradient(135deg, #2c7da0, #1f5e7e);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
    }

    .header-title h4 {
        font-size: 1.6rem;
        font-weight: 600;
        letter-spacing: -0.3px;
        color: #0f2c3d;
        margin: 0;
    }

    .header-title span {
        font-size: 0.9rem;
        color: #5b6e8c;
        display: block;
        margin-top: 4px;
    }

    .update-badge {
        background: #eef2ff;
        padding: 6px 14px;
        border-radius: 40px;
        font-size: 0.8rem;
        color: #2c7da0;
        font-weight: 500;
        backdrop-filter: blur(2px);
    }

    /* Sección / tarjeta principal */
    .report-section {
        background: white;
        border-radius: 28px;
        padding: 24px 28px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02), 0 2px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 24px;
        border-bottom: 2px solid #eef2f8;
        padding-bottom: 14px;
    }

    .section-header h5 {
        font-size: 1.35rem;
        font-weight: 600;
        color: #0f2c3d;
        letter-spacing: -0.2px;
        margin: 0;
    }

    /* Formulario de filtros */
    .filters-row {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
        align-items: flex-end;
    }
    .filter-group {
        flex: 1;
        min-width: 180px;
    }
    .filter-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 500;
        color: #5b6e8c;
        margin-bottom: 6px;
    }
    .filter-group input, .filter-group select {
        width: 100%;
        padding: 8px 14px;
        border-radius: 30px;
        border: 1px solid #e2e8f0;
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    .filter-group input:focus, .filter-group select:focus {
        outline: none;
        border-color: #2c7da0;
        box-shadow: 0 0 0 3px rgba(44,125,160,0.1);
    }
    .btn-modern-primary {
        background: linear-gradient(135deg, #2c7da0, #1f5e7e);
        border: none;
        color: white;
        border-radius: 40px;
        padding: 8px 20px;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        width: 100%;
        justify-content: center;
    }
    .btn-modern-primary:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #236b8a, #154f6b);
        box-shadow: 0 6px 12px rgba(44,125,160,0.2);
    }

    /* Tarjetas de resumen (widget-card-1 adaptadas) */
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }
    .summary-card {
        background: white;
        border-radius: 24px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0, 0, 0, 0.03);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s;
    }
    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.1);
    }
    .summary-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .summary-label {
        font-size: 0.8rem;
        font-weight: 500;
        color: #5b6e8c;
    }
    .summary-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #0f2c3d;
    }
    .summary-icon {
        width: 56px;
        height: 56px;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }
    .summary-icon.blue {
        background: #e6f7ff;
        color: #1f7b9c;
    }
    .summary-icon.green {
        background: #e0f2e9;
        color: #1e7e34;
    }

    /* Tabla moderna */
    .modern-table-wrapper {
        overflow-x: auto;
        border-radius: 20px;
    }
    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.9rem;
    }
    .table-modern thead th {
        background: #f8fafd;
        color: #1e2f44;
        font-weight: 600;
        padding: 14px 16px;
        border-bottom: 2px solid #e2e8f0;
        font-size: 0.85rem;
        letter-spacing: 0.3px;
    }
    .table-modern tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #edf2f7;
        color: #2d3a4b;
        vertical-align: middle;
    }
    .table-modern tbody tr:hover {
        background-color: #fafcff;
    }

    /* Personalización de DataTables */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e2e8f0;
        border-radius: 40px;
        padding: 8px 16px;
        background-color: white;
        font-size: 0.85rem;
        width: 260px;
        transition: all 0.2s;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: #2c7da0;
        box-shadow: 0 0 0 3px rgba(44,125,160,0.1);
    }
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #e2e8f0;
        border-radius: 30px;
        padding: 5px 24px 5px 12px;
        background-color: white;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 30px !important;
        border: none !important;
        margin: 0 2px;
        padding: 6px 12px;
        background: transparent;
        color: #2d3a4b !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #2c7da0 !important;
        color: white !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #eef2ff !important;
        color: #1f5e7e !important;
    }
    .dataTables_wrapper .dataTables_info {
        font-size: 0.8rem;
        color: #5b6e8c;
        padding-top: 12px;
    }

    /* Animación fadeIn */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px);}
        to { opacity: 1; transform: translateY(0);}
    }

    /* Responsive */
    @media (max-width: 640px) {
        .dashboard-container { padding: 16px; }
        .report-section { padding: 18px; }
        .filters-row { flex-direction: column; }
        .dataTables_wrapper .dataTables_filter input { width: 100%; }
        .summary-cards { gap: 16px; }
    }
</style>

<div class="dashboard-container">
    <!-- Encabezado estilo dashboard -->
    <div class="page-header">
        <div class="header-title">
            <i class="icofont icofont-chart-line"></i>
            <div>
                <h4>Reporte Financiero y Productividad</h4>
                <span>Consulta ingresos por médico o por servicio en un rango de fechas</span>
            </div>
        </div>
        <div class="update-badge">
            <i class="icofont icofont-calendar"></i> Análisis dinámico
        </div>
    </div>

    <!-- Tarjeta principal -->
    <div class="report-section">
        <div class="section-header">
            <h5><i class="icofont icofont-chart-histogram"></i> Generador de reportes</h5>
        </div>

        <!-- Formulario de filtros -->
        <form id="form_reporte_productividad">
            <div class="filters-row">
                <div class="filter-group">
                    <label><i class="icofont icofont-calendar"></i> Fecha inicio</label>
                    <input type="date" class="form-control" name="fecha_inicio" value="<?php echo $inicioMes; ?>" required>
                </div>
                <div class="filter-group">
                    <label><i class="icofont icofont-calendar"></i> Fecha fin</label>
                    <input type="date" class="form-control" name="fecha_fin" value="<?php echo $hoy; ?>" required>
                </div>
                <div class="filter-group">
                    <label><i class="icofont icofont-chart-pie"></i> Agrupar por</label>
                    <select class="form-control" name="agrupar_por">
                        <option value="servicio">Servicio</option>
                        <option value="medico">Médico</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn-modern-primary"><i class="ti-search"></i> Generar</button>
                </div>
            </div>
        </form>

        <!-- Tarjetas resumen -->
        <div class="summary-cards">
            <div class="summary-card">
                <div class="summary-info">
                    <span class="summary-label">Total citas finalizadas</span>
                    <span class="summary-value" id="rep_total_citas">0</span>
                </div>
                <div class="summary-icon blue">
                    <i class="icofont icofont-listing-box"></i>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-info">
                    <span class="summary-label">Ingresos generados</span>
                    <span class="summary-value" id="rep_total_ingresos">$0.00</span>
                </div>
                <div class="summary-icon green">
                    <i class="icofont icofont-money-bag"></i>
                </div>
            </div>
        </div>

        <!-- Tabla de resultados -->
        <div class="modern-table-wrapper">
            <table id="tbl_reporte_productividad" class="table-modern w-100">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Total Citas</th>
                        <th>Ingreso Total</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
  function moneda(valor) {
    return `$${Number(valor || 0).toFixed(2)}`;
  }

  function cargarReporteProductividad() {
    $.ajax({
      url: '_actions/get_reporte_productividad.php',
      type: 'POST',
      dataType: 'json',
      data: $('#form_reporte_productividad').serialize(),
      success: function (response) {
        if (!response || !response.success) {
          alert(response && response.message ? response.message : 'No se pudo generar el reporte.');
          return;
        }

        $('#rep_total_citas').text(response.resumen.total_citas || 0);
        $('#rep_total_ingresos').text(moneda(response.resumen.total_ingresos || 0));

        const tabla = $('#tbl_reporte_productividad').DataTable();
        tabla.clear();
        tabla.rows.add(response.data || []);
        tabla.draw();
      },
      error: function () {
        alert('Error de conexión al generar el reporte.');
      }
    });
  }

  $(document).ready(function () {
    $('#tbl_reporte_productividad').DataTable({
      dom: '<"top"f>rt<"bottom"lip><"clear">',
      paging: true,
      searching: true,
      destroy: true,
      data: [],
      columns: [
        { data: 'concepto' },
        { data: 'total_citas' },
        {
          data: 'ingresos_totales',
          render: function (data) {
            return moneda(data);
          }
        }
      ],
      language: {
        emptyTable: "Sin datos para el rango seleccionado",
        info: "_START_ a _END_ de _TOTAL_ registros",
        infoEmpty: "No hay registros para mostrar",
        lengthMenu: "Mostrar _MENU_ registros",
        loadingRecords: "Cargando...",
        processing: "Procesando...",
        search: "Buscar:",
        zeroRecords: "No se encontraron resultados",
        paginate: {
          first: "Primero",
          last: "Último",
          next: "Siguiente",
          previous: "Anterior"
        }
      }
    });

    $('#form_reporte_productividad').on('submit', function (e) {
      e.preventDefault();
      cargarReporteProductividad();
    });

    cargarReporteProductividad();
  });
</script>