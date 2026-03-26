<?php
require_once __DIR__ . '/auth_guard.php';
agp_require_role_page(['admin']);
?>

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
          <h4 class="sub-title">Catálogo de Estatus de Citas</h4>
          <div class="d-flex justify-content-end mb-3">
            <button class="btn" data-toggle="modal" data-target="#modalAgregarEstatus"
              style="background-color: #0edc3bff; color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: all 0.2s ease-in-out;"
              onmouseover="this.style.backgroundColor='#1e7e34'" onmouseout="this.style.backgroundColor='#0edc3bff'">
              <i class="ti-plus"></i> Agregar Estatus
            </button>
          </div>

          <div class="card">
            <div class="card-body">
              <table id="tbl_estatus" class="table table-row-bordered gy-5" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre del Estatus</th>
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
    cargarTablaEstatus();
  });

  function cargarTablaEstatus() {
    $('#tbl_estatus').DataTable({
      dom: '<"top"f>rt<"bottom"lip><"clear">',
      paging: true,
      destroy: true,
      ajax: {
        url: '_actions/datasource_estatus_citas.php',
        type: 'GET',
        dataSrc: ''
      },
      columns: [
        {data: 'id_estatus'},
        {
          data: 'nombre',
          render: function(data) {
  
             return `<span class="badge badge-secondary f-14">${data}</span>`;
          }
        },
        {
          data: null,
          orderable: false,
          searchable: false,
          render: function(data, type, row) {
            return `
              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalEditarEstatus" title="Editar Estatus" 
                onclick="editarEstatus('${row.id_estatus}', '${row.nombre}', '${row.activo}')">
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

  function eliminarEstatus(id_estatus) {
    if (confirm("¿Estás seguro de que deseas eliminar este estatus? (No se podrá eliminar si ya hay citas usando este estatus).")) {
      fetch(`_actions/eliminar_estatus_cita.php`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `id_estatus=${encodeURIComponent(id_estatus)}`
        })
        .then(response => response.json())
        .then(data => {
          alert(data.mensaje || (data.success ? "Eliminado correctamente" : "Error al eliminar"));
          if (data.success) { $('#tbl_estatus').DataTable().ajax.reload(); }
        })
        .catch(error => { alert("Error al procesar la solicitud: " + error); });
    }
  }

  function editarEstatus(id, nombre, activo) {
      $('#e_id_estatus').val(id);
      $('#e_nombre').val(nombre);
      $('#e_activo').val(activo);
}
</script>

<?php include('frm_modals_estatus_citas.php'); ?>
