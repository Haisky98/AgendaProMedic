<?php require_once __DIR__ . '/auth_guard.php'; ?>
<div class="page-body">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div class="card-header-right">
            <i class="icofont icofont-spinner-alt-5"></i>
          </div>
        </div>
        <div class="card-block">
          <h4 class="sub-title">Catálogo de Servicios y Procedimientos</h4>
          <div class="d-flex justify-content-end mb-3">
            <button class="btn" data-toggle="modal" data-target="#modalAgregarServicio"
              style="background-color: #0edc3bff; color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: all 0.2s ease-in-out;"
              onmouseover="this.style.backgroundColor='#1e7e34'" onmouseout="this.style.backgroundColor='#0edc3bff'">
              <i class="ti-plus"></i> Agregar Servicio
            </button>
          </div>

          <div class="card">
            <div class="card-body">
              <table id="tbl_servicios" class="table table-row-bordered gy-5" style="width:100%">
                <thead>
                  <tr>
                    <th>Especialidad</th>
                    <th>Nombre del Servicio</th>
                    <th>Duración Est. (Mins)</th>
                    <th>Costo ($)</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    cargarTablaServicios();
  });

  function cargarTablaServicios() {
    $('#tbl_servicios').DataTable({
      dom: '<"top"f>rt<"bottom"lip><"clear">',
      paging: true,
      destroy: true,
      ajax: {
        url: '_actions/datasource_servicios.php',
        type: 'GET',
        dataSrc: ''
      },
      columns: [
        {data: 'nombre_especialidad'},
        {data: 'nombre'},
        {data: 'duracion_estimada_minutos', render: function(data){ return data + ' min'; }},
        {data: 'costo', render: function(data){ return '$' + parseFloat(data).toFixed(2); }},
        {
          data: 'activo',
          render: function(data, type, row) {
             return data == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
          }
        },
        {
          data: null,
          orderable: false,
          searchable: false,
          render: function(data, type, row) {
            return `
              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalEditarServicio" title="Editar Servicio" 
                onclick="editarServicio('${row.id_servicio}', '${row.id_especialidad || ''}', '${row.nombre}', '${row.duracion_estimada_minutos}', '${row.costo}', '${row.activo}')">
                <i class="ti-pencil"></i> Editar
              </button>
            `;
          }
        }
      ],
      language: {
        emptyTable: "No hay registros disponibles",
        info: "_START_ a _END_ de _TOTAL_ registros",
        infoEmpty: "No hay registros para mostrar",
        lengthMenu: "Mostrar _MENU_ registros",
        loadingRecords: "Cargando...",
        processing: "Procesando...",
        search: "Buscar:",
        zeroRecords: "No se encontraron resultados",
        paginate: { first: "Primero", last: "Último", next: "Siguiente", previous: "Anterior" }
      }
    });
  }

  function eliminarServicio(id_servicio) {
    if (confirm("¿Estás seguro de que deseas desactivar/eliminar este servicio?")) {
      fetch(`_actions/eliminar_servicio.php`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `id_servicio=${encodeURIComponent(id_servicio)}`
        })
        .then(response => response.json())
        .then(data => {
          alert(data.mensaje || (data.success ? "Eliminado correctamente" : "Error al eliminar"));
          if (data.success) { $('#tbl_servicios').DataTable().ajax.reload(); }
        })
        .catch(error => { alert("Error al procesar la solicitud: " + error); });
    }
  }

  function editarServicio(id, idEspecialidad, nombre, duracion, costo, activo) {
      $('#e_id_servicio').val(id);
      $('#e_id_especialidad').val(idEspecialidad);
      $('#e_nombre').val(nombre);
      $('#e_duracion').val(duracion);
      $('#e_costo').val(costo);
      $('#e_activo').val(activo);
  }
</script>

<?php include('frm_modals_servicios.php'); ?>
