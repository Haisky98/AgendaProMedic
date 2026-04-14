<?php
require_once __DIR__ . '/auth_guard.php';
agp_require_role_page(['admin']);
?>

<style>
    /* Estilos existentes (se mantienen igual) */
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

    .users-section {
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

    .btn-modern {
        background: linear-gradient(135deg, #2c7da0, #1f5e7e);
        border: none;
        color: white;
        border-radius: 40px;
        padding: 8px 20px;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #236b8a, #154f6b);
        color: white;
        box-shadow: 0 6px 12px rgba(44,125,160,0.2);
    }

    .btn-outline-modern {
        background: transparent;
        border: 1px solid #cbd5e1;
        border-radius: 40px;
        padding: 8px 20px;
        font-weight: 500;
        font-size: 0.85rem;
        color: #4a5b7a;
        transition: all 0.2s;
    }

    .btn-outline-modern:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #1e2f44;
    }

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

    .badge-primary-modern {
        background: #e6f7ff;
        color: #1f7b9c;
        padding: 4px 12px;
        border-radius: 40px;
        font-weight: 500;
        font-size: 0.75rem;
    }

    .badge-info-modern {
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

    .btn-action-edit {
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
        margin-right: 6px;
    }

    .btn-action-edit:hover {
        background: #2c7da0;
        border-color: #2c7da0;
        color: white;
    }

    .btn-action-delete {
        background: none;
        border: 1px solid #cbd5e1;
        border-radius: 30px;
        padding: 5px 14px;
        font-size: 0.75rem;
        font-weight: 500;
        color: #c0392b;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-action-delete:hover {
        background: #c0392b;
        border-color: #c0392b;
        color: white;
    }

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

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px);}
        to { opacity: 1; transform: translateY(0);}
    }

    @media (max-width: 640px) {
        .dashboard-container { padding: 16px; }
        .users-section { padding: 18px; }
        .section-header { flex-direction: column; align-items: flex-start; gap: 12px; }
        .dataTables_wrapper .dataTables_filter input { width: 100%; }
        .btn-action-edit, .btn-action-delete { margin-bottom: 5px; }
    }

    /* ========== ESTILOS NUEVOS PARA MODALES MODERNOS ========== */
    .modern-modal .modal-content {
        border: none;
        border-radius: 28px;
        box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
    }

    .modal-header-gradient-primary {
        background: linear-gradient(135deg, #2c7da0, #1f5e7e);
        padding: 18px 24px;
        border-bottom: none;
        display: flex;
    }

    .modal-header-gradient-warning {
        background: linear-gradient(135deg, #f39c12, #e67e22);
        padding: 18px 24px;
        border-bottom: none;
        display: flex;
    }

    .modal-header-gradient-primary h5,
    .modal-header-gradient-warning h5 {
        font-weight: 600;
        font-size: 1.3rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        color: white;
    }

    .modal-header-gradient-primary .close,
    .modal-header-gradient-warning .close {
        color: white;
        text-shadow: none;
        opacity: 0.8;
        font-size: 1.8rem;
        padding: 0;
        margin: -6px 0 -6px auto;
        transition: opacity 0.2s;
    }

    .modal-header-gradient-primary .close:hover,
    .modal-header-gradient-warning .close:hover {
        opacity: 1;
    }

    .modern-modal .modal-body {
        padding: 28px 28px 20px 28px;
        background: #ffffff;
    }

    .modern-modal .form-group {
        margin-bottom: 1.2rem;
    }

    .modern-modal label {
        font-weight: 500;
        color: #1e2f44;
        font-size: 0.85rem;
        margin-bottom: 6px;
        letter-spacing: -0.2px;
    }

    .modern-modal .form-control {
        border: 1px solid #e2e8f0;
        border-radius: 40px;
        padding: 10px 18px;
        font-size: 0.9rem;
        transition: all 0.2s;
        background-color: #fefefe;
    }

    .modern-modal .form-control:focus {
        border-color: #2c7da0;
        box-shadow: 0 0 0 3px rgba(44,125,160,0.1);
        outline: none;
    }

    .modern-modal select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234a5b7a' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1.2rem;
    }

    .modern-modal .modal-footer {
        border-top: 1px solid #edf2f7;
        padding: 18px 28px;
        background: #fcfdff;
        border-bottom-left-radius: 28px;
        border-bottom-right-radius: 28px;
    }

    /* Ajuste para botones dentro del modal footer */
    .modern-modal .btn-modern {
        padding: 8px 22px;
    }

    .modern-modal .btn-outline-modern {
        padding: 8px 22px;
    }

    /* Espaciado entre botones */
    .modal-footer .btn + .btn {
        margin-left: 10px;
    }

    /* Responsive modales */
    @media (max-width: 576px) {
        .modern-modal .modal-body {
            padding: 20px;
        }
        .modern-modal .modal-footer {
            padding: 15px 20px;
            flex-direction: column;
            gap: 10px;
        }
        .modal-footer .btn + .btn {
            margin-left: 0;
        }
        .modern-modal .btn-modern,
        .modern-modal .btn-outline-modern {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="dashboard-container">
    <div class="page-header">
        <div class="header-title">
            <i class="icofont icofont-users"></i>
            <div>
                <h4>Usuarios Médicos</h4>
                <span>Gestión de cuentas de acceso para el cuerpo médico</span>
            </div>
        </div>
        <div class="update-badge">
            <i class="icofont icofont-shield"></i> Administración
        </div>
    </div>

    <div class="users-section">
        <div class="section-header">
            <h5><i class="icofont icofont-list"></i> Lista de usuarios</h5>
            <button class="btn-modern" data-toggle="modal" data-target="#modalAgregarUsuario">
                <i class="ti-plus"></i> Nuevo Usuario Médico
            </button>
        </div>

        <div class="modern-table-wrapper">
            <table id="tbl_usuarios" class="table-modern" style="width:100%">
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

<!-- MODAL AGREGAR (Rediseñado) -->
<div class="modal fade modern-modal" id="modalAgregarUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header-gradient-primary">
        <h5 class="modal-title">
            <i class="icofont icofont-user-add"></i> Alta de Usuario Médico
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_agregar_usuario" method="POST">
          <input type="hidden" name="rol" value="medico">

          <div class="form-group">
            <label><i class="icofont icofont-user"></i> Usuario</label>
            <input type="text" class="form-control" name="usuario" placeholder="ej. dr_garcia" required>
          </div>

          <div class="form-group">
            <label><i class="icofont icofont-id-card"></i> Nombre visible</label>
            <input type="text" class="form-control" name="nombre" placeholder="Dr. Juan García" required>
          </div>

          <div class="form-group">
            <label><i class="icofont icofont-stethoscope"></i> Médico vinculado</label>
            <select class="form-control" id="id_medico_usuario" name="id_medico" required>
              <option value="">Cargando médicos...</option>
            </select>
          </div>

          <div class="form-group">
            <label><i class="icofont icofont-lock"></i> Contraseña</label>
            <input type="password" class="form-control" name="password" minlength="6" required>
          </div>

          <div class="form-group">
            <label><i class="icofont icofont-verification-check"></i> Confirmar contraseña</label>
            <input type="password" class="form-control" name="password_confirm" minlength="6" required>
          </div>

          <div class="form-group">
            <label><i class="icofont icofont-ui-status"></i> Estatus</label>
            <select class="form-control" name="activo" required>
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>

          <div class="modal-footer px-0 pb-0">
            <button type="button" class="btn-outline-modern" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn-modern">Guardar Usuario</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- MODAL EDITAR (Rediseñado) -->
<div class="modal fade modern-modal" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header-gradient-warning">
        <h5 class="modal-title">
            <i class="icofont icofont-edit"></i> Editar Usuario Médico
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_editar_usuario" method="POST">
          <input type="hidden" name="id" id="e_id_usuario" />

          <div class="form-group">
            <label><i class="icofont icofont-user"></i> Usuario</label>
            <input type="text" class="form-control" name="usuario" id="e_usuario" required>
          </div>

          <div class="form-group">
            <label><i class="icofont icofont-id-card"></i> Nombre visible</label>
            <input type="text" class="form-control" name="nombre" id="e_nombre" required>
          </div>

          <div class="form-group">
            <label><i class="icofont icofont-stethoscope"></i> Médico vinculado</label>
            <select class="form-control" id="e_id_medico_usuario" name="id_medico" required>
              <option value="">Cargando médicos...</option>
            </select>
          </div>

          <div class="form-group">
            <label><i class="icofont icofont-ui-status"></i> Estatus</label>
            <select class="form-control" name="activo" id="e_activo_usuario" required>
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>

          <div class="form-group">
            <label><i class="icofont icofont-key"></i> Nueva contraseña (opcional)</label>
            <input type="password" class="form-control" name="password" id="e_password" minlength="6" placeholder="Dejar vacío para mantener actual">
          </div>

          <div class="form-group">
            <label><i class="icofont icofont-verification-check"></i> Confirmar nueva contraseña</label>
            <input type="password" class="form-control" name="password_confirm" id="e_password_confirm" minlength="6">
          </div>

          <div class="modal-footer px-0 pb-0">
            <button type="button" class="btn-outline-modern" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn-modern" style="background: linear-gradient(135deg, #e67e22, #d35400);">Actualizar</button>
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
            var badgeClass = (String(data).toLowerCase() === 'admin') ? 'badge-primary-modern' : 'badge-info-modern';
            return '<span class="' + badgeClass + '">' + data + '</span>';
          }
        },
        {
          data: 'medico_nombre',
          render: function (data, type, row) {
            if (row.id_medico > 0 && data) {
              return escapeHtmlStatic(data);
            }
            return '<span class="text-muted">Sin vincular</span>';
          }
        },
        {
          data: 'activo',
          render: function (data) {
            return Number(data) === 1
              ? '<span class="badge-success-modern">Activo</span>'
              : '<span class="badge-danger-modern">Inactivo</span>';
          }
        },
        {
          data: null,
          orderable: false,
          searchable: false,
          render: function (data, type, row) {
            var rol = String(row.rol || '').toLowerCase();
            if (rol !== 'medico') {
              return '<span class="text-muted">No editable</span>';
            }

            var usuario = encodeURIComponent(String(row.usuario || ''));
            var nombre = encodeURIComponent(String(row.nombre || ''));
            var idMedico = Number(row.id_medico || 0);
            var activo = Number(row.activo || 0);

            return '' +
              '<button class="btn-action-edit btn-editar-usuario" ' +
                'data-id="' + Number(row.id || 0) + '" ' +
                'data-usuario="' + usuario + '" ' +
                'data-nombre="' + nombre + '" ' +
                'data-id-medico="' + idMedico + '" ' +
                'data-activo="' + activo + '">' +
                '<i class="ti-pencil"></i> Editar' +
              '</button>' +
              '<button class="btn-action-delete btn-eliminar-usuario" ' +
                'data-id="' + Number(row.id || 0) + '" ' +
                'data-usuario="' + usuario + '">' +
                '<i class="ti-trash"></i> Eliminar' +
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
      $select.empty().append('<option value="">Seleccione médico</option>');
      $.each(data, function (index, medico) {
        $select.append($('<option>', {
          value: medico.id_medico,
          text: medico.nombre_completo
        }));
      });
    }).fail(function () {
      $(selector).empty().append('<option value="">No fue posible cargar médicos</option>');
    });
  }

  function escapeHtmlStatic(str) {
    if (!str) return '';
    return String(str).replace(/[&<>]/g, function(m) {
      if (m === '&') return '&amp;';
      if (m === '<') return '&lt;';
      if (m === '>') return '&gt;';
      return m;
    });
  }
</script>