<?php
require_once __DIR__ . '/auth_guard.php';

$rolActual = agp_current_role();
$esMedico = ($rolActual === 'medico');
$idMedicoSesion = isset($_SESSION['id_medico']) ? (int)$_SESSION['id_medico'] : 0;
?>
<style>
.container { background: #f8f9fa; }
.card { background-color: #ffffff; border-radius: 1rem; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05); }
#tabla_citas { border-collapse: separate; border-spacing: 0; background-color: #fff; border-radius: 0.75rem; overflow: hidden; }
#tabla_citas thead th { background-color: #0d6efd; color: white; text-align: center; }
#tabla_citas tbody tr:nth-child(even) { background-color: #f0f4f8; }
#tabla_citas tbody tr:hover { background-color: #e9f2ff; transition: background-color 0.3s; }
#tabla_citas tfoot input { width: 100%; padding: 4px; border: 1px solid #ced4da; border-radius: 0.25rem; }
#tabla_citas tfoot { background-color: #f8f9fa; }
#tabla_citas td, #tabla_citas th { vertical-align: middle; }
.dt-button { border-radius: 0.5rem !important; padding: 0.5rem 1rem !important; font-size: 0.9rem; font-weight: 500; border: none; transition: all 0.3s ease; }
.dt-button.btn-excel { background-color: #28a745 !important; color: #fff !important; }
.dt-button.btn-excel:hover { background-color: #218838 !important; }
.dt-button.btn-pdf { background-color: #dc3545 !important; color: #fff !important; }
.dt-button.btn-pdf:hover { background-color: #c82333 !important; }
.dt-button.btn-print { background-color: #6c757d !important; color: #fff !important; }
.dt-button.btn-print:hover { background-color: #5a6268 !important; }
</style>

<div class="main-body">
  <div class="page-wrapper">
    <div class="page-header card">
      <div class="row align-items-end">
        <div class="col-lg-8">
          <div class="page-header-title">
            <i class="icofont icofont-stethoscope bg-c-blue"></i>
            <div class="d-inline">
              <h4><?php echo $esMedico ? 'Mis Citas Médicas' : 'Recepción de Citas Médicas'; ?></h4>
              <span><?php echo $esMedico ? 'Vista de solo lectura de tus pacientes citados' : 'Gestión de pacientes agendados'; ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12 container">
      <div class="page-header card">
        <div class="card shadow border-0 rounded-4">
          <div class="card-body">
            <div class="row align-items-end m-b-20">
              <div class="col-md-4">
                <label for="filtro_fecha_citas" class="font-weight-bold">Fecha de citas</label>
                <input type="date" id="filtro_fecha_citas" class="form-control">
              </div>
              <div class="col-md-2">
                <button type="button" id="btn_hoy_citas" class="btn btn-outline-primary btn-block">
                  <i class="icofont icofont-calendar"></i> Hoy
                </button>
              </div>
            </div>
            <div class="table-responsive">
              <table id="tabla_citas" class="table table-hover table-borderless align-middle w-100">
                <thead class="table-light text-center">
                  <tr>
                    <th>PACIENTE</th>
                    <th>TELÉFONO</th>
                    <th>MÉDICO</th>
                    <th>SERVICIO</th>
                    <th>PRECIO</th>
                    <th>FECHA</th>
                    <th>HORA</th>
                    <th>ESTATUS</th>
                    <?php if (!$esMedico): ?>
                      <th>ACCIONES</th>
                    <?php endif; ?>
                  </tr>
                </thead>
                <tfoot class="bg-light">
                  <tr>
                    <th><input type="text" placeholder="Buscar paciente" /></th>
                    <th><input type="text" placeholder="Buscar teléfono" /></th>
                    <th><input type="text" placeholder="Buscar médico" /></th>
                    <th><input type="text" placeholder="Buscar servicio" /></th>
                    <th><input type="text" placeholder="Buscar precio" /></th>
                    <th><input type="text" placeholder="Buscar fecha" /></th>
                    <th><input type="text" placeholder="Buscar hora" /></th>
                    <th><input type="text" placeholder="Buscar estatus" /></th>
                    <?php if (!$esMedico): ?>
                      <th></th>
                    <?php endif; ?>
                  </tr>
                </tfoot>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if (!$esMedico): ?>
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="modalEditarLabel"><i class="icofont icofont-ui-edit"></i> Gestionar Cita</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_editar_cita" method="POST">
          <input type="hidden" name="id_cita" id="id_cita">

          <h4 class="sub-title">Detalles del Paciente</h4>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Paciente</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="m_paciente" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Contacto</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="m_telefono" readonly>
            </div>
          </div>

          <h4 class="sub-title">Detalles de la Consulta</h4>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Médico</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="m_medico" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Servicio</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="m_servicio" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Motivo</label>
            <div class="col-sm-9">
              <textarea class="form-control" id="m_motivo" rows="3" readonly></textarea>
            </div>
          </div>

          <h4 class="sub-title text-primary">Actualizar Cita</h4>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label font-weight-bold">Estatus</label>
            <div class="col-sm-9">
              <select class="form-control" id="id_estatus" name="id_estatus" required>
                <option value="">Cargando estatus...</option>
              </select>
            </div>
          </div>

          <div class="text-right m-t-20">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary"><i class="icofont icofont-save"></i> Guardar Cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function () {
  const esMedico = <?php echo $esMedico ? 'true' : 'false'; ?>;
  const idMedicoSesion = <?php echo (int)$idMedicoSesion; ?>;
  const formatoMoneda = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' });
  const $filtroFecha = $('#filtro_fecha_citas');

  function obtenerFechaHoy() {
    const hoy = new Date();
    const anio = hoy.getFullYear();
    const mes = String(hoy.getMonth() + 1).padStart(2, '0');
    const dia = String(hoy.getDate()).padStart(2, '0');
    return `${anio}-${mes}-${dia}`;
  }

  function normalizarTexto(texto) {
    return String(texto || '')
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .toUpperCase()
      .trim();
  }

  $filtroFecha.val(obtenerFechaHoy());

  if (esMedico && idMedicoSesion <= 0) {
    Swal.fire('Aviso', 'Tu usuario médico no está vinculado a un registro de médico. Contacta al administrador.', 'warning');
  }

  $("#tabla_citas tfoot th").each(function () {
    var title = $(this).text();
    if (title !== "") {
      $(this).html("<input type='text' class='form-control form-control-sm' placeholder='Buscar " + title + "'/>");
    }
  });

  const columnas = [
    { data: 'nombre_paciente' },
    { data: 'telefono_paciente' },
    { data: 'medico' },
    { data: 'servicio' },
    {
      data: 'costo_servicio',
      render: function(data, type) {
        const costo = Number(data || 0);
        if (type === 'sort' || type === 'type') {
          return costo;
        }
        return formatoMoneda.format(costo);
      }
    },
    { data: 'fecha_cita' },
    { data: 'hora' },
    {
      data: 'estatus',
      render: function(data) {
        let badgeClass = 'badge-secondary';
        const estatus = normalizarTexto(data);

        if (estatus === 'PENDIENTE') badgeClass = 'badge-warning text-dark';
        if (estatus === 'CONFIRMADA') badgeClass = 'badge-info';
        if (estatus === 'EN CURSO') badgeClass = 'badge-primary';
        if (estatus === 'FINALIZADA') badgeClass = 'badge-success';
        if (estatus === 'CANCELADA' || estatus === 'NO ASISTIO') badgeClass = 'badge-danger';

        return `<span class="badge ${badgeClass} f-14">${data}</span>`;
      }
    }
  ];

  if (!esMedico) {
    columnas.push({
      data: null,
      orderable: false,
      searchable: false,
      render: function(data, type, row) {
        return `
          <button class="btn btn-sm btn-primary btn-atender"
            data-id="${row.id_cita}"
            data-paciente="${row.nombre_paciente}"
            data-telefono="${row.telefono_paciente || ''}"
            data-medico="${row.medico}"
            data-servicio="${row.servicio}"
            data-motivo="${row.motivo || 'Sin especificar'}"
            data-toggle="modal" data-target="#modalEditar" title="Gestionar Cita">
            <i class="icofont icofont-ui-edit"></i> Gestionar
          </button>
        `;
      }
    });
  }

  const tbl = $('#tabla_citas').DataTable({
    responsive: true,
    dom: 'Bfrtip',
    buttons: [
      { extend: 'excelHtml5', text: '<i class="icofont icofont-file-excel"></i> Excel', className: 'btn-excel dt-button' },
      { extend: 'pdfHtml5', text: '<i class="icofont icofont-file-pdf"></i> PDF', className: 'btn-pdf dt-button', orientation: 'landscape', pageSize: 'A4' },
      { extend: 'print', text: '<i class="icofont icofont-print"></i> Imprimir', className: 'btn-print dt-button' }
    ],
    paging: true,
    processing: true,
    search: false,
    order: [[6, 'asc']],
    ajax: {
      url: '_actions/get_tabla_citas.php',
      type: 'POST',
      dataSrc: '',
      data: function (d) {
        d.fecha = $filtroFecha.val() || '';
      }
    },
    columns: columnas,
    language: {
      emptyTable: 'No hay citas registradas',
      info: 'Mostrando _START_ a _END_ de _TOTAL_ citas',
      infoEmpty: 'Mostrando 0 a 0 de 0 citas',
      loadingRecords: 'Cargando...',
      processing: 'Procesando...',
      paginate: { first: 'Primero', last: 'Último', next: 'Siguiente', previous: 'Anterior' }
    }
  });

  $filtroFecha.on('change', function () {
    tbl.ajax.reload();
  });

  $('#btn_hoy_citas').on('click', function () {
    $filtroFecha.val(obtenerFechaHoy());
    tbl.ajax.reload();
  });

  tbl.columns().every(function () {
    var that = this;
    $('input', this.footer()).on('keyup change', function () {
      if (that.search() !== this.value) {
        that.search(this.value).draw();
      }
    });
  });

  if (esMedico) {
    return;
  }

  function cargarEstatus() {
    $.getJSON('_actions/get_estatus_cita.php', function(data) {
      const $select = $('#id_estatus');
      $select.empty().append('<option value="">Seleccione el estatus actual</option>');
      $.each(data, function(index, est) {
        $select.append($('<option>', { value: est.id_estatus, text: est.nombre }));
      });
    });
  }
  cargarEstatus();

  $(document).on('click', '.btn-atender', function() {
    $('#id_cita').val($(this).data('id'));
    $('#m_paciente').val($(this).data('paciente'));
    $('#m_telefono').val($(this).data('telefono'));
    $('#m_medico').val($(this).data('medico'));
    $('#m_servicio').val($(this).data('servicio'));
    $('#m_motivo').val($(this).data('motivo'));
  });

  $('#form_editar_cita').on('submit', function(e) {
    e.preventDefault();

    const id_estatus = $('#id_estatus').val();
    if (!id_estatus) {
      Swal.fire('Requerido', 'Debe seleccionar un estatus para la cita.', 'warning');
      return;
    }

    $.ajax({
      url: '_actions/update_estatus_cita.php',
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          Swal.fire({
            icon: 'success',
            title: 'Estatus actualizado',
            text: 'La cita ha sido modificada correctamente.'
          });
          $('#modalEditar').modal('hide');
          tbl.ajax.reload(null, false);
          $('#form_editar_cita')[0].reset();
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.message || 'Ocurrió un error inesperado'
          });
        }
      },
      error: function() {
        Swal.fire('Error', 'Error en la conexión con el servidor', 'error');
      }
    });
  });
});
</script>
