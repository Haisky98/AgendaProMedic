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
          <h4 class="sub-title">Catálogo de Especialidades</h4>
          <div class="d-flex justify-content-end mb-3">
            <button
              class="btn"
              data-toggle="modal"
              data-target="#modalAgregarEspecialidad"
              style="
                background-color: #0edc3bff;
                color: white;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transition: all 0.2s ease-in-out;
              "
              onmouseover="this.style.backgroundColor='#1e7e34'"
              onmouseout="this.style.backgroundColor='#0edc3bff'">
              <i class="ti-plus"></i> Agregar Especialidad
            </button>
          </div>

          <div class="card">
            <div class="card-body">
              <table id="tbl_especialidades" class="table table-row-bordered gy-5" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre de la Especialidad</th>
                    <th>Descripción</th>
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
    cargarTablaEspecialidades();
  });

  function cargarTablaEspecialidades() {
    $('#tbl_especialidades').DataTable({
      dom: '<"top"f>rt<"bottom"lip><"clear">',
      paging: true,
      destroy: true,
      ajax: {
        url: '_actions/datasource_especialidades.php',
        type: 'GET',
        dataSrc: ''
      },
      columns: [
        {data: 'id_especialidad'},
        {data: 'nombre'},
        {data: 'descripcion'},
        {
          data: 'activo',
          render: function(data, type, row) {
             if(data == 1) {
                return '<span class="badge badge-success">Activo</span>';
             } else {
                return '<span class="badge badge-danger">Inactivo</span>';
             }
          }
        },
        {
          data: null,
          orderable: false,
          searchable: false,
          render: function(data, type, row) {
            return `
              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalEditarEspecialidad" title="Editar especialidad" 
                onclick="editarEspecialidad('${row.id_especialidad}', '${row.nombre}', '${row.descripcion}', '${row.activo}')">
                <i class="ti-pencil"></i> Editar
              </button>
            `;
          }
        }
      ],
      language: {
        emptyTable: "No hay registros disponibles en la tabla",
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

  function eliminarEspecialidad(id_especialidad) {
    if (confirm("¿Estás seguro de que deseas desactivar/eliminar esta especialidad?")) {
      fetch(`_actions/eliminar_especialidad.php`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `id_especialidad=${encodeURIComponent(id_especialidad)}`
        })
        .then(response => response.json())
        .then(data => {
          alert(data.mensaje || (data.success ? "Eliminado correctamente" : "Error al eliminar"));
          if (data.success) {
            $('#tbl_especialidades').DataTable().ajax.reload();
          }
        })
        .catch(error => {
          alert("Error al procesar la solicitud: " + error);
        });
    }
  }

  function editarEspecialidad(id, nombre, descripcion, activo) {
      $('#e_id_especialidad').val(id);
      $('#e_nombre').val(nombre);
      $('#e_descripcion').val(descripcion);
      $('#e_activo').val(activo);
  }
</script>

<?php include('frm_modals_especialidades.php'); ?>
