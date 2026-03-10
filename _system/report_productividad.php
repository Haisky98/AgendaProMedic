<?php
require_once __DIR__ . '/auth_guard.php';
$hoy = date('Y-m-d');
$inicioMes = date('Y-m-01');
?>

<div class="page-body">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h5>Reporte Financiero y Productividad</h5>
          <span>Consulta ingresos por médico o por servicio en un rango de fechas.</span>
        </div>
        <div class="card-block">
          <form id="form_reporte_productividad">
            <div class="row">
              <div class="col-md-3 form-group">
                <label class="font-weight-bold">Fecha inicio</label>
                <input type="date" class="form-control" name="fecha_inicio" value="<?php echo $inicioMes; ?>" required>
              </div>
              <div class="col-md-3 form-group">
                <label class="font-weight-bold">Fecha fin</label>
                <input type="date" class="form-control" name="fecha_fin" value="<?php echo $hoy; ?>" required>
              </div>
              <div class="col-md-3 form-group">
                <label class="font-weight-bold">Agrupar por</label>
                <select class="form-control" name="agrupar_por">
                  <option value="servicio">Servicio</option>
                  <option value="medico">Médico</option>
                </select>
              </div>
              <div class="col-md-3 form-group d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-block"><i class="ti-search"></i> Generar</button>
              </div>
            </div>
          </form>

          <div class="row m-t-20">
            <div class="col-md-6 col-xl-3">
              <div class="card widget-card-1">
                <div class="card-block-small">
                  <i class="icofont icofont-listing-box bg-c-blue card1-icon"></i>
                  <span class="text-c-blue f-w-600">Total citas finalizadas</span>
                  <h4 id="rep_total_citas">0</h4>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3">
              <div class="card widget-card-1">
                <div class="card-block-small">
                  <i class="icofont icofont-money-bag bg-c-green card1-icon"></i>
                  <span class="text-c-green f-w-600">Ingresos generados</span>
                  <h4 id="rep_total_ingresos">$0.00</h4>
                </div>
              </div>
            </div>
          </div>

          <div class="table-responsive">
            <table id="tbl_reporte_productividad" class="table table-striped table-bordered w-100">
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
