<?php
require_once __DIR__ . '/auth_guard.php';

$rolActual = agp_current_role();
$esMedico = ($rolActual === 'medico');
$idMedicoSesion = isset($_SESSION['id_medico']) ? (int)$_SESSION['id_medico'] : 0;
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
    .appointments-section {
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

    /* Filtros */
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
    .filter-group input, .filter-group button {
        width: 100%;
        padding: 8px 14px;
        border-radius: 30px;
        border: 1px solid #e2e8f0;
        font-size: 0.85rem;
        transition: all 0.2s;
    }
    .filter-group input:focus {
        outline: none;
        border-color: #2c7da0;
        box-shadow: 0 0 0 3px rgba(44,125,160,0.1);
    }
    .btn-outline-modern {
        background: transparent;
        border: 1px solid #2c7da0;
        color: #2c7da0;
        border-radius: 40px;
        padding: 8px 14px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-outline-modern:hover {
        background: #2c7da0;
        color: white;
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
    /* Badges modernos (para estatus) */
    .badge-warning-modern {
        background: #fff3e0;
        color: #e67e22;
        padding: 4px 12px;
        border-radius: 40px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    .badge-info-modern {
        background: #e6f7ff;
        color: #1f7b9c;
        padding: 4px 12px;
        border-radius: 40px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    .badge-primary-modern {
        background: #eef2ff;
        color: #2c7da0;
        padding: 4px 12px;
        border-radius: 40px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    .badge-success-modern {
        background: #e0f2e9;
        color: #1e7e34;
        padding: 4px 12px;
        border-radius: 40px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    .badge-danger-modern {
        background: #fee9e6;
        color: #c0392b;
        padding: 4px 12px;
        border-radius: 40px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    .badge-secondary-modern {
        background: #eef2f8;
        color: #5b6e8c;
        padding: 4px 12px;
        border-radius: 40px;
        font-weight: 500;
        font-size: 0.75rem;
    }

    /* Botones de acción */
    .btn-action-primary {
        background: none;
        border: 1px solid #cbd5e1;
        border-radius: 30px;
        padding: 5px 14px;
        font-size: 0.75rem;
        font-weight: 500;
        color: #2c7da0;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-action-primary:hover {
        background: #2c7da0;
        border-color: #2c7da0;
        color: white;
    }

    /* Botones de DataTables (Excel, PDF, Imprimir) */
    .dt-button {
        border-radius: 30px !important;
        padding: 6px 16px !important;
        font-size: 0.8rem;
        font-weight: 500;
        border: none;
        transition: all 0.2s ease;
        margin-right: 6px;
    }
    .dt-button.btn-excel {
        background-color: #1e7e34 !important;
        color: white !important;
    }
    .dt-button.btn-excel:hover {
        background-color: #155d27 !important;
        transform: translateY(-1px);
    }
    .dt-button.btn-pdf {
        background-color: #c0392b !important;
        color: white !important;
    }
    .dt-button.btn-pdf:hover {
        background-color: #a93226 !important;
        transform: translateY(-1px);
    }
    .dt-button.btn-print {
        background-color: #5b6e8c !important;
        color: white !important;
    }
    .dt-button.btn-print:hover {
        background-color: #4a5a73 !important;
        transform: translateY(-1px);
    }

    /* Personalización de DataTables (paginación, búsqueda) */
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

    /* Footer de la tabla (filtros por columna) */
    .table-modern tfoot th input {
        width: 100%;
        padding: 6px 10px;
        border-radius: 30px;
        border: 1px solid #e2e8f0;
        font-size: 0.8rem;
    }

    /* Animación fadeIn */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px);}
        to { opacity: 1; transform: translateY(0);}
    }

    /* Responsive */
    @media (max-width: 640px) {
        .dashboard-container { padding: 16px; }
        .appointments-section { padding: 18px; }
        .filters-row { flex-direction: column; }
        .dataTables_wrapper .dataTables_filter input { width: 100%; }
    }
</style>

<div class="dashboard-container">
    <!-- Encabezado estilo dashboard -->
    <div class="page-header">
        <div class="header-title">
            <i class="icofont icofont-stethoscope"></i>
            <div>
                <h4><?php echo $esMedico ? 'Mis Citas Médicas' : 'Recepción de Citas Médicas'; ?></h4>
                <span><?php echo $esMedico ? 'Vista de solo lectura de tus pacientes citados' : 'Gestión de pacientes agendados'; ?></span>
            </div>
        </div>
        <div class="update-badge">
            <i class="icofont icofont-calendar"></i> Agenda diaria
        </div>
    </div>

    <!-- Tarjeta principal -->
    <div class="appointments-section">
        <div class="section-header">
            <h5><i class="icofont icofont-list"></i> Listado de citas</h5>
            <!-- Los botones de exportación se inyectan aquí automáticamente por DataTables -->
        </div>

        <!-- Filtros -->
        <div class="filters-row">
            <div class="filter-group">
                <label><i class="icofont icofont-calendar"></i> Fecha de citas</label>
                <input type="date" id="filtro_fecha_citas" class="form-control">
            </div>
            <div class="filter-group">
                <label>&nbsp;</label>
                <button type="button" id="btn_hoy_citas" class="btn-outline-modern">
                    <i class="icofont icofont-calendar"></i> Hoy
                </button>
            </div>
        </div>

        <div class="modern-table-wrapper">
            <table id="tabla_citas" class="table-modern w-100">
                <thead>
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
                <tfoot>
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

<?php if (!$esMedico): ?>
<!-- Modal Editar (sin cambios funcionales) -->
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

  // Filtros por columna (se reemplazan los placeholders)
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
        let badgeClass = 'badge-secondary-modern';
        const estatus = normalizarTexto(data);

        if (estatus === 'PENDIENTE') badgeClass = 'badge-warning-modern';
        if (estatus === 'CONFIRMADA') badgeClass = 'badge-info-modern';
        if (estatus === 'EN CURSO') badgeClass = 'badge-primary-modern';
        if (estatus === 'FINALIZADA') badgeClass = 'badge-success-modern';
        if (estatus === 'CANCELADA' || estatus === 'NO ASISTIO') badgeClass = 'badge-danger-modern';

        return `<span class="${badgeClass}">${data}</span>`;
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
          <button class="btn-action-primary btn-atender"
            data-id="${row.id_cita}"
            data-paciente="${row.nombre_paciente.replace(/['"]/g, '\\"')}"
            data-telefono="${(row.telefono_paciente || '').replace(/['"]/g, '\\"')}"
            data-medico="${row.medico.replace(/['"]/g, '\\"')}"
            data-servicio="${row.servicio.replace(/['"]/g, '\\"')}"
            data-motivo="${(row.motivo || 'Sin especificar').replace(/['"]/g, '\\"')}"
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

  // Filtros por columna (footer)
  tbl.columns().every(function () {
    var that = this;
    $('input', this.footer()).on('keyup change', function () {
      if (that.search() !== this.value) {
        that.search(this.value).draw();
      }
    });
  });

  if (esMedico) {
    return; // No continuar con lógica de edición si es médico
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