<?php require_once __DIR__ . '/auth_guard.php'; ?>
<div class="page-body">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div class="card-header-right">
            <i class="icofont icofont-ui-clock"></i>
          </div>
        </div>
        <div class="card-block">
          <h4 class="sub-title">Catálogo de Horarios de Citas</h4>
          <div class="d-flex justify-content-end mb-3">
            <button class="btn"
              data-toggle="modal"
              data-target="#modalAgregarHoraCita"
              style="background-color: #0edc3bff; color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: all 0.2s ease-in-out;"
              onmouseover="this.style.backgroundColor='#1e7e34'"
              onmouseout="this.style.backgroundColor='#0edc3bff'">
              <i class="ti-plus"></i> Agregar Bloque
            </button>
          </div>

          <div class="card">
            <div class="card-body">
              <table id="tbl_horas_cita" class="table table-row-bordered gy-5" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Hora de Inicio</th>
                    <th>Hora de Fin</th>
                    <th>Etiqueta</th>
                    <th>Turno</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
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
</div>

<script>
  $(document).ready(function () {
    cargarTablaHoraCita();
  });

  function cargarTablaHoraCita() {
    $('#tbl_horas_cita').DataTable({
      dom: '<"top"f>rt<"bottom"lip><"clear">',
      paging: true,
      destroy: true,
      ajax: {
        url: '_actions/datasource_hora_cita.php',
        type: 'GET',
        dataSrc: ''
      },
      columns: [
        { data: 'id_hora' },
        { data: 'hora_inicio', render: function(data) { return (data || '').substring(0, 5); } },
        { data: 'hora_fin', render: function(data) { return (data || '').substring(0, 5); } },
        { data: 'etiqueta' },
        { data: 'turno' },
        {
          data: 'activo',
          render: function (data) {
            return Number(data) === 1
              ? '<span class="badge badge-success">Activo</span>'
              : '<span class="badge badge-danger">Inactivo</span>';
          }
        },
        {
          data: null,
          orderable: false,
          searchable: false,
          render: function (data, type, row) {
            const etiquetaSafe = String(row.etiqueta || '').replace(/'/g, "\\'");
            const turnoSafe = String(row.turno || '').replace(/'/g, "\\'");
            const nuevoEstado = Number(row.activo) === 1 ? 0 : 1;
            const textoToggle = Number(row.activo) === 1 ? 'Desactivar' : 'Activar';
            const claseToggle = Number(row.activo) === 1 ? 'btn-warning' : 'btn-success';

            return `
              <button class="btn btn-sm btn-primary m-b-5" data-toggle="modal" data-target="#modalEditarHoraCita"
                onclick="editarHoraCita('${row.id_hora}','${(row.hora_inicio || '').substring(0, 5)}','${(row.hora_fin || '').substring(0, 5)}','${etiquetaSafe}','${turnoSafe}','${row.activo}')">
                <i class="ti-pencil"></i> Editar
              </button>
              <button class="btn btn-sm ${claseToggle} m-b-5" onclick="toggleHoraCita('${row.id_hora}','${nuevoEstado}')">
                <i class="ti-power-off"></i> ${textoToggle}
              </button>
            `;
          }
        }
      ],
      language: {
        emptyTable: "No hay horarios registrados",
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
  }

  function editarHoraCita(id, inicio, fin, etiqueta, turno, activo) {
    $('#e_id_hora').val(id);
    $('#e_hora_inicio').val(inicio);
    $('#e_hora_fin').val(fin);
    $('#e_etiqueta').val(etiqueta);
    $('#e_turno').val(turno);
    $('#e_activo').val(activo);
  }

  function toggleHoraCita(idHora, activo) {
    fetch('_actions/toggle_hora_cita.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id_hora=${encodeURIComponent(idHora)}&activo=${encodeURIComponent(activo)}`
    })
    .then(r => r.json())
    .then(resp => {
      alert(resp.message || (resp.success ? 'Estatus actualizado.' : 'No se pudo actualizar.'));
      if (resp.success) {
        $('#tbl_horas_cita').DataTable().ajax.reload(null, false);
      }
    })
    .catch(() => alert('Error de conexión al cambiar el estatus.'));
  }

  function eliminarHoraCita(idHora) {
    if (!confirm('Esta acción eliminará el horario. ¿Deseas continuar?')) {
      return;
    }

    fetch('_actions/eliminar_hora_cita.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id_hora=${encodeURIComponent(idHora)}`
    })
    .then(r => r.json())
    .then(resp => {
      alert(resp.message || (resp.success ? 'Horario eliminado.' : 'No se pudo eliminar.'));
      if (resp.success) {
        $('#tbl_horas_cita').DataTable().ajax.reload(null, false);
      }
    })
    .catch(() => alert('Error de conexión al eliminar.'));
  }
</script>

<?php include __DIR__ . '/frm_modals_hora_cita.php'; ?>
