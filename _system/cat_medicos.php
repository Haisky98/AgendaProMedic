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
          <h4 class="sub-title">Catálogo de Médicos</h4>
          <div class="d-flex justify-content-end mb-3">
            <button
              class="btn"
              data-toggle="modal"
              data-target="#modalAgregarMedico"
              style="
                background-color: #0edc3bff;
                color: white;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transition: all 0.2s ease-in-out;
              "
              onmouseover="this.style.backgroundColor='#1e7e34'"
              onmouseout="this.style.backgroundColor='#0edc3bff'">
              <i class="ti-plus"></i> Agregar Médico
            </button>
          </div>

          <div class="card">
            <div class="card-body">
              <table id="tbl_medicos" class="table table-row-bordered gy-5" style="width:100%">
                <thead>
                  <tr>
                    <th>Nombre del Médico</th>
                    <th>Cédula</th>
                    <th>Especialidad</th>
                    <th>Consultorio</th>
                    <th>Contacto</th>
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
    cargarTablaMedicos();
  });

  function cargarTablaMedicos() {
    $('#tbl_medicos').DataTable({
      dom: '<"top"f>rt<"bottom"lip><"clear">',
      paging: true,
      destroy: true,
      ajax: {
        url: '_actions/datasource_medicos.php',
        type: 'GET',
        dataSrc: ''
      },
      columns: [
        {data: 'nombre_completo'},
        {data: 'cedula_profesional'},
        {data: 'especialidad'}, 
        {data: 'consultorio'}, 
        {
          data: null,
          render: function(data, type, row) {
            return `<div><i class="icofont icofont-phone"></i> ${row.telefono}</div>
                    <div><i class="icofont icofont-envelope"></i> ${row.correo}</div>`;
          }
        },
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
              <button class="btn btn-sm btn-primary m-b-5" data-toggle="modal" data-target="#modalEditarMedico" title="Editar Médico" 
                onclick="editarMedico('${row.id_medico}', '${row.nombre_completo}', '${row.cedula_profesional}', '${row.id_especialidad}', '${row.id_consultorio}', '${row.telefono}', '${row.correo}', '${row.activo}')">
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

  function eliminarMedico(id_medico) {
    if (confirm("¿Estás seguro de que deseas desactivar/eliminar a este médico?")) {
      fetch(`_actions/eliminar_medico.php`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `id_medico=${encodeURIComponent(id_medico)}`
        })
        .then(response => response.json())
        .then(data => {
          alert(data.mensaje || (data.success ? "Eliminado correctamente" : "Error al eliminar"));
          if (data.success) {
            $('#tbl_medicos').DataTable().ajax.reload();
          }
        })
        .catch(error => {
          alert("Error al procesar la solicitud: " + error);
        });
    }
  }

  function editarMedico(id, nombre, cedula, idEspecialidad, idConsultorio, tel, correo, activo) {
      $('#e_id_medico').val(id);
      $('#e_nombre').val(nombre);
      $('#e_cedula').val(cedula);
      $('#e_especialidad').val(idEspecialidad);
      $('#e_consultorio').val(idConsultorio);
      $('#e_telefono').val(tel);
      $('#e_correo').val(correo);
      $('#e_activo').val(activo);
  }
</script>

<?php include('frm_modals_medicos.php'); ?>
