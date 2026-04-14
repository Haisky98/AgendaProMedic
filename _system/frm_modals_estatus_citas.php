<!-- ==================== ESTILOS (mismos que el dashboard) ==================== -->
<style>
  .custom-modal .modal-content {
    border: none;
    border-radius: 28px;
    box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.2);
    overflow: hidden;
  }

  .custom-modal .modal-header {
    background: linear-gradient(135deg, #2c7da0, #1f5e7e);
    padding: 1.2rem 1.5rem;
    border-bottom: none;
  }

  .custom-modal .modal-header.editar-header {
    background: linear-gradient(135deg, #e6a017, #c97e0a);
  }

  .custom-modal .modal-header .modal-title {
    color: white;
    font-weight: 600;
    font-size: 1.3rem;
    letter-spacing: -0.2px;
  }

  .custom-modal .modal-header .close {
    color: white;
    opacity: 0.8;
    text-shadow: none;
    font-size: 1.8rem;
    font-weight: 300;
    transition: opacity 0.2s;
  }

  .custom-modal .modal-header .close:hover {
    opacity: 1;
  }

  .custom-modal .modal-body {
    padding: 1.8rem;
    background: #ffffff;
  }

  .custom-modal .form-group {
    margin-bottom: 1.2rem;
  }

  .custom-modal .form-label {
    font-weight: 600;
    font-size: 0.85rem;
    color: #1e2f44;
    margin-bottom: 0.4rem;
    display: block;
    letter-spacing: 0.3px;
  }

  .custom-modal .form-control,
  .custom-modal .form-select {
    width: 100%;
    padding: 0.7rem 1rem;
    font-size: 0.95rem;
    border: 1px solid #e2e8f0;
    border-radius: 60px;
    background-color: #fff;
    transition: all 0.2s ease;
    color: #0f2c3d;
  }

  .custom-modal .form-control:focus,
  .custom-modal .form-select:focus {
    outline: none;
    border-color: #2c7da0;
    box-shadow: 0 0 0 3px rgba(44, 125, 160, 0.2);
  }

  .custom-modal .btn-cancelar {
    background: #f1f5f9;
    border: none;
    border-radius: 60px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    color: #475569;
    transition: all 0.2s;
  }

  .custom-modal .btn-cancelar:hover {
    background: #e2e8f0;
    color: #0f172a;
  }

  .custom-modal .btn-guardar {
    background: linear-gradient(135deg, #2c7da0, #1f5e7e);
    border: none;
    border-radius: 60px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    color: white;
    transition: transform 0.15s, box-shadow 0.15s;
  }

  .custom-modal .btn-guardar:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(44, 125, 160, 0.3);
  }

  .custom-modal .btn-actualizar {
    background: linear-gradient(135deg, #e6a017, #c97e0a);
    border: none;
    border-radius: 60px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    color: white;
    transition: transform 0.15s, box-shadow 0.15s;
  }

  .custom-modal .btn-actualizar:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(230, 160, 23, 0.3);
  }

  .custom-modal .modal-footer-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 1.5rem;
  }

  @media (max-width: 576px) {
    .custom-modal .modal-body {
      padding: 1.2rem;
    }
    .custom-modal .btn-cancelar,
    .custom-modal .btn-guardar,
    .custom-modal .btn-actualizar {
      padding: 0.4rem 1.2rem;
    }
  }
</style>

<!-- ==================== MODAL AGREGAR ESTATUS ==================== -->
<div class="modal fade custom-modal" id="modalAgregarEstatus" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="icofont icofont-plus-circle me-2"></i> Agregar Nuevo Estatus</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="form_agregar_estatus" method="POST">
          <div class="form-group">
            <label class="form-label">Nombre del Estatus <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="nombre" placeholder="Ej. En Sala de Espera" required>
          </div>
          <div class="form-group">
            <label class="form-label">Estado</label>
            <select class="form-select" name="activo" required>
              <option value="1">Activo (Visible)</option>
              <option value="0">Inactivo (Oculto)</option>
            </select>
          </div>
          <div class="modal-footer-buttons">
            <button type="button" class="btn-cancelar" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn-guardar"><i class="icofont icofont-save"></i> Guardar Estatus</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ==================== MODAL EDITAR ESTATUS ==================== -->
<div class="modal fade custom-modal" id="modalEditarEstatus" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header editar-header">
        <h5 class="modal-title"><i class="icofont icofont-ui-edit me-2"></i> Editar Estatus</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="form_editar_estatus" method="POST">
          <input type="hidden" id="e_id_estatus" name="id_estatus">
          <div class="form-group">
            <label class="form-label">Nombre del Estatus <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="e_nombre" name="nombre" required>
          </div>
          <div class="form-group">
            <label class="form-label">Estado</label>
            <select class="form-select" id="e_activo" name="activo" required>
              <option value="1">Activo (Visible)</option>
              <option value="0">Inactivo (Oculto)</option>
            </select>
          </div>
          <div class="modal-footer-buttons">
            <button type="button" class="btn-cancelar" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn-actualizar"><i class="icofont icofont-refresh"></i> Actualizar Estatus</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ==================== SCRIPT CON SWEETALERT2 Y FUNCIONES ==================== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Agregar estatus
    $('#form_agregar_estatus').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '_actions/create_estatus_cita.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('#modalAgregarEstatus').modal('hide');
                    $('#form_agregar_estatus')[0].reset();
                    $('#tbl_estatus').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Guardado!',
                        text: 'Estatus guardado correctamente.',
                        confirmButtonColor: '#2c7da0',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo guardar el estatus.',
                        confirmButtonColor: '#d33'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo conectar con el servidor.',
                    confirmButtonColor: '#d33'
                });
            }
        });
    });

    // Editar estatus
    $('#form_editar_estatus').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '_actions/update_estatus_cita.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('#modalEditarEstatus').modal('hide');
                    $('#tbl_estatus').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: 'Estatus actualizado correctamente.',
                        confirmButtonColor: '#e6a017',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo actualizar el estatus.',
                        confirmButtonColor: '#d33'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo conectar con el servidor.',
                    confirmButtonColor: '#d33'
                });
            }
        });
    });
});

// Función global para cargar datos en el modal de edición (debes llamarla desde el botón Editar)
function editarEstatus(id, nombre, activo) {
    $('#e_id_estatus').val(id);
    $('#e_nombre').val(nombre);
    $('#e_activo').val(activo);
}
</script>