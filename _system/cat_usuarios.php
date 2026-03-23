<?php
require_once __DIR__ . '/auth_guard.php';
agp_require_role_page(['admin']);
?>

<div class="page-body">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h5>Usuarios Médicos</h5>
        </div>
        <div class="card-block">
          <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">
              <i class="ti-plus"></i> Nuevo Usuario Médico
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
                  <th>Médico Vinculado</th>
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

<div class="modal fade" id="modalAgregarUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white">Alta de Usuario Médico</h5>
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
            <label>Médico vinculado</label>
            <select class="form-control" id="id_medico_usuario" name="id_medico" required>
              <option value="">Cargando médicos...</option>
            </select>
          </div>

          <div class="form-group">
            <label>Contraseña</label>
            <input type="password" class="form-control" name="password" minlength="6" required>
          </div>

          <div class="form-group">
            <label>Confirmar contraseña</label>
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

<div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title text-dark">Editar Usuario Médico</h5>
        <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_editar_usuario" method="POST">
          <input type="hidden" name="id" id="e_id_usuario" />

          <div class="form-group">
            <label>Usuario</label>
            <input type="text" class="form-control" name="usuario" id="e_usuario" required>
          </div>

          <div class="form-group">
            <label>Nombre visible</label>
            <input type="text" class="form-control" name="nombre" id="e_nombre" required>
          </div>

          <div class="form-group">
            <label>Médico vinculado</label>
            <select class="form-control" id="e_id_medico_usuario" name="id_medico" required>
              <option value="">Cargando médicos...</option>
            </select>
          </div>

          <div class="form-group">
            <label>Estatus</label>
            <select class="form-control" name="activo" id="e_activo_usuario" required>
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>

          <div class="form-group">
            <label>Nueva contraseña (opcional)</label>
            <input type="password" class="form-control" name="password" id="e_password" minlength="6">
          </div>

          <div class="form-group">
            <label>Confirmar nueva contraseña</label>
            <input type="password" class="form-control" name="password_confirm" id="e_password_confirm" minlength="6">
          </div>

          <div class="text-right m-t-20">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-warning">Guardar cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  var tablaUsuarios = null;

  $(document).ready(function () {
    cargarTablaUsuarios();
    cargarMedicosActivos('#id_medico_usuario');
    cargarMedicosActivos('#e_id_medico_usuario');

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
            if (tablaUsuarios) {
              tablaUsuarios.ajax.reload(null, false);
            }
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

    $('#form_editar_usuario').on('submit', function (e) {
      e.preventDefault();

      $.ajax({
        url: '_actions/update_usuario.php',
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        success: function (response) {
          if (response.success) {
            $('#modalEditarUsuario').modal('hide');
            $('#form_editar_usuario')[0].reset();
            if (tablaUsuarios) {
              tablaUsuarios.ajax.reload(null, false);
            }
            Swal.fire('Correcto', response.message || 'Usuario actualizado.', 'success');
          } else {
            Swal.fire('Error', response.message || 'No se pudo actualizar el usuario.', 'error');
          }
        },
        error: function () {
          Swal.fire('Error', 'No se pudo completar la solicitud.', 'error');
        }
      });
    });

    $(document).on('click', '.btn-editar-usuario', function () {
      var id = Number($(this).attr('data-id') || 0);
      var usuario = decodeURIComponent(String($(this).attr('data-usuario') || ''));
      var nombre = decodeURIComponent(String($(this).attr('data-nombre') || ''));
      var idMedico = Number($(this).attr('data-id-medico') || 0);
      var activo = Number($(this).attr('data-activo') || 0);

      $('#e_id_usuario').val(id);
      $('#e_usuario').val(usuario);
      $('#e_nombre').val(nombre);
      $('#e_id_medico_usuario').val(idMedico);
      $('#e_activo_usuario').val(activo);
      $('#e_password').val('');
      $('#e_password_confirm').val('');
      $('#modalEditarUsuario').modal('show');
    });

    $(document).on('click', '.btn-eliminar-usuario', function () {
      var id = Number($(this).attr('data-id') || 0);
      var usuario = decodeURIComponent(String($(this).attr('data-usuario') || ''));

      if (id <= 0) {
        Swal.fire('Error', 'No se pudo identificar el usuario a eliminar.', 'error');
        return;
      }

      Swal.fire({
        title: 'Eliminar usuario',
        text: 'Se eliminará el usuario "' + usuario + '". Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#d33'
      }).then(function (result) {
        if (!result.isConfirmed) {
          return;
        }

        $.ajax({
          url: '_actions/delete_usuario.php',
          type: 'POST',
          dataType: 'json',
          data: { id: id },
          success: function (response) {
            if (response.success) {
              if (tablaUsuarios) {
                tablaUsuarios.ajax.reload(null, false);
              }
              Swal.fire('Correcto', response.message || 'Usuario eliminado.', 'success');
            } else {
              Swal.fire('Error', response.message || 'No se pudo eliminar el usuario.', 'error');
            }
          },
          error: function () {
            Swal.fire('Error', 'No se pudo completar la solicitud.', 'error');
          }
        });
      });
    });
  });

  function cargarTablaUsuarios() {
    tablaUsuarios = $('#tbl_usuarios').DataTable({
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
        },
        {
          data: null,
          orderable: false,
          searchable: false,
          render: function (data, type, row) {
            var rol = String(row.rol || '').toLowerCase();
            if (rol !== 'medico') {
              return '<span class=\"text-muted\">No editable</span>';
            }

            var usuario = encodeURIComponent(String(row.usuario || ''));
            var nombre = encodeURIComponent(String(row.nombre || ''));
            var idMedico = Number(row.id_medico || 0);
            var activo = Number(row.activo || 0);

            return '' +
              '<button class=\"btn btn-sm btn-warning btn-editar-usuario m-r-5\" ' +
                'data-id=\"' + Number(row.id || 0) + '\" ' +
                'data-usuario=\"' + usuario + '\" ' +
                'data-nombre=\"' + nombre + '\" ' +
                'data-id-medico=\"' + idMedico + '\" ' +
                'data-activo=\"' + activo + '\">' +
                '<i class=\"ti-pencil\"></i> Editar' +
              '</button>' +
              '<button class=\"btn btn-sm btn-danger btn-eliminar-usuario\" ' +
                'data-id=\"' + Number(row.id || 0) + '\" ' +
                'data-usuario=\"' + usuario + '\">' +
                '<i class=\"ti-trash\"></i> Eliminar' +
              '</button>';
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

  function cargarMedicosActivos(selector) {
    $.getJSON('_actions/get_medicos_activos.php', function (data) {
      var $select = $(selector);
      $select.empty().append('<option value=\"\">Seleccione médico</option>');
      $.each(data, function (index, medico) {
        $select.append($('<option>', {
          value: medico.id_medico,
          text: medico.nombre_completo
        }));
      });
    }).fail(function () {
      $(selector).empty().append('<option value=\"\">No fue posible cargar médicos</option>');
    });
  }
</script>
