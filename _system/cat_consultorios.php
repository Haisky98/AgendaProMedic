<?php require_once __DIR__ . '/auth_guard.php'; ?>
<div class="page-body">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div class="card-header-right">
            <i class="icofont icofont-hospital"></i>
          </div>
        </div>
        <div class="card-block">
          <h4 class="sub-title">Catálogo de Consultorios y Salas</h4>
          <div class="d-flex justify-content-end mb-3">
            <button class="btn"
              data-toggle="modal"
              data-target="#modalAgregarConsultorio"
              style="background-color: #0edc3bff; color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: all 0.2s ease-in-out;"
              onmouseover="this.style.backgroundColor='#1e7e34'"
              onmouseout="this.style.backgroundColor='#0edc3bff'">
              <i class="ti-plus"></i> Agregar Consultorio
            </button>
          </div>

          <div class="card">
            <div class="card-body">
              <table id="tbl_consultorios" class="table table-row-bordered gy-5" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Número/Sala</th>
                    <th>Ubicación</th>
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
    cargarTablaConsultorios();
  });

  function cargarTablaConsultorios() {
    $('#tbl_consultorios').DataTable({
      dom: '<"top"f>rt<"bottom"lip><"clear">',
      paging: true,
      destroy: true,
      ajax: {
        url: '_actions/datasource_consultorios.php',
        type: 'GET',
        dataSrc: ''
      },
      columns: [
        { data: 'id_consultorio' },
        { data: 'numero_sala' },
        { data: 'ubicacion' },
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
            const numeroSalaSafe = String(row.numero_sala || '').replace(/'/g, "\\'");
            const ubicacionSafe = String(row.ubicacion || '').replace(/'/g, "\\'");
            const nuevoEstado = Number(row.activo) === 1 ? 0 : 1;
            const textoToggle = Number(row.activo) === 1 ? 'Desactivar' : 'Activar';
            const claseToggle = Number(row.activo) === 1 ? 'btn-warning' : 'btn-success';

            return `
              <button class="btn btn-sm btn-primary m-b-5" data-toggle="modal" data-target="#modalEditarConsultorio"
                onclick="editarConsultorio('${row.id_consultorio}','${numeroSalaSafe}','${ubicacionSafe}','${row.activo}')">
                <i class="ti-pencil"></i> Editar
              </button>
              <button class="btn btn-sm ${claseToggle} m-b-5" onclick="toggleConsultorio('${row.id_consultorio}','${nuevoEstado}')">
                <i class="ti-power-off"></i> ${textoToggle}
              </button>
            `;
          }
        }
      ],
      language: {
        emptyTable: "No hay consultorios registrados",
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

  function editarConsultorio(id, numeroSala, ubicacion, activo) {
    $('#e_id_consultorio').val(id);
    $('#e_numero_sala').val(numeroSala);
    $('#e_ubicacion').val(ubicacion);
    $('#e_activo_consultorio').val(activo);
  }

  function toggleConsultorio(idConsultorio, activo) {
    fetch('_actions/toggle_consultorio.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id_consultorio=${encodeURIComponent(idConsultorio)}&activo=${encodeURIComponent(activo)}`
    })
    .then(r => r.json())
    .then(resp => {
      alert(resp.message || (resp.success ? 'Estatus actualizado.' : 'No se pudo actualizar.'));
      if (resp.success) {
        $('#tbl_consultorios').DataTable().ajax.reload(null, false);
      }
    })
    .catch(() => alert('Error de conexión al cambiar el estatus.'));
  }

  function eliminarConsultorio(idConsultorio) {
    if (!confirm('Esta acción eliminará el consultorio. ¿Deseas continuar?')) {
      return;
    }

    fetch('_actions/eliminar_consultorio.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id_consultorio=${encodeURIComponent(idConsultorio)}`
    })
    .then(r => r.json())
    .then(resp => {
      alert(resp.message || (resp.success ? 'Consultorio eliminado.' : 'No se pudo eliminar.'));
      if (resp.success) {
        $('#tbl_consultorios').DataTable().ajax.reload(null, false);
      }
    })
    .catch(() => alert('Error de conexión al eliminar.'));
  }
</script>

<?php include __DIR__ . '/frm_modals_consultorios.php'; ?>
