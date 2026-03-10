<?php
require_once __DIR__ . '/auth_guard.php';
agp_require_role_page(['admin']);
?>

<div class="page-body">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h5>Usuarios Medicos</h5>
        </div>
        <div class="card-block">
          <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">
              <i class="ti-plus"></i> Nuevo Usuario Medico
            </button>
          </div>

          <div class="table-responsive">
            <table id="tbl_usuarios" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Usuario</th>
                  <th>Nombre</th>
                  <th>Rol</th>
                  <th>Medico Vinculado</th>
                  <th>Estatus</th>
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

<div class="modal fade" id="modalAgregarUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white">Alta de Usuario Medico</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_agregar_usuario" method="POST">
          <input type="hidden" name="rol" value="medico">

          <div class="form-group">
            <label>Usuario</label>
            <input type="text" class="form-control" name="usuario" required>
          </div>

          <div class="form-group">
            <label>Nombre visible</label>
            <input type="text" class="form-control" name="nombre" required>
          </div>

          <div class="form-group">
            <label>Medico vinculado</label>
            <select class="form-control" id="id_medico_usuario" name="id_medico" required>
              <option value="">Cargando medicos...</option>
            </select>
          </div>

          <div class="form-group">
            <label>Contrasena</label>
            <input type="password" class="form-control" name="password" minlength="6" required>
          </div>

          <div class="form-group">
            <label>Confirmar contrasena</label>
            <input type="password" class="form-control" name="password_confirm" minlength="6" required>
          </div>

          <div class="form-group">
            <label>Estatus</label>
            <select class="form-control" name="activo" required>
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>

          <div class="text-right m-t-20">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    cargarTablaUsuarios();
    cargarMedicosActivos();

    $('#form_agregar_usuario').on('submit', function (e) {
      e.preventDefault();

      $.ajax({
        url: '_actions/create_usuario.php',
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        success: function (response) {
          if (response.success) {
            $('#modalAgregarUsuario').modal('hide');
            $('#form_agregar_usuario')[0].reset();
            $('#tbl_usuarios').DataTable().ajax.reload(null, false);
            Swal.fire('Correcto', response.message || 'Usuario creado.', 'success');
          } else {
            Swal.fire('Error', response.message || 'No se pudo crear el usuario.', 'error');
          }
        },
        error: function () {
          Swal.fire('Error', 'No se pudo completar la solicitud.', 'error');
        }
      });
    });
  });

  function cargarTablaUsuarios() {
    $('#tbl_usuarios').DataTable({
      destroy: true,
      ajax: {
        url: '_actions/datasource_usuarios.php',
        type: 'GET',
        dataSrc: ''
      },
      columns: [
        { data: 'id' },
        { data: 'usuario' },
        { data: 'nombre' },
        {
          data: 'rol',
          render: function (data) {
            var badgeClass = (String(data).toLowerCase() === 'admin') ? 'badge-primary' : 'badge-info';
            return '<span class=\"badge ' + badgeClass + '\">' + data + '</span>';
          }
        },
        {
          data: 'medico_nombre',
          render: function (data, type, row) {
            if (row.id_medico > 0 && data) {
              return data;
            }
            return '<span class=\"text-muted\">Sin vincular</span>';
          }
        },
        {
          data: 'activo',
          render: function (data) {
            return Number(data) === 1
              ? '<span class=\"badge badge-success\">Activo</span>'
              : '<span class=\"badge badge-danger\">Inactivo</span>';
          }
        }
      ],
      language: {
        emptyTable: 'No hay usuarios registrados',
        info: '_START_ a _END_ de _TOTAL_ registros',
        infoEmpty: 'No hay registros para mostrar',
        lengthMenu: 'Mostrar _MENU_ registros',
        loadingRecords: 'Cargando...',
        processing: 'Procesando...',
        search: 'Buscar:',
        zeroRecords: 'No se encontraron resultados',
        paginate: { first: 'Primero', last: 'Ultimo', next: 'Siguiente', previous: 'Anterior' }
      }
    });
  }

  function cargarMedicosActivos() {
    $.getJSON('_actions/get_medicos_activos.php', function (data) {
      var $select = $('#id_medico_usuario');
      $select.empty().append('<option value=\"\">Seleccione medico</option>');
      $.each(data, function (index, medico) {
        $select.append($('<option>', {
          value: medico.id_medico,
          text: medico.nombre_completo
        }));
      });
    }).fail(function () {
      $('#id_medico_usuario').empty().append('<option value=\"\">No fue posible cargar medicos</option>');
    });
  }
</script>
