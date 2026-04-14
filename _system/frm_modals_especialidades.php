<style>
  /* Estilos personalizados para los modales (coherentes con el dashboard) */
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

  .custom-modal textarea.form-control {
    border-radius: 20px;
    resize: vertical;
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
<!-- Modal AGREGAR especialidad -->
<div class="modal fade custom-modal" id="modalAgregarEspecialidad" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="icofont icofont-plus-circle me-2"></i> Agregar Nueva Especialidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_agregar_especialidad" method="POST">
          <div class="form-group">
            <label class="form-label">Nombre de la Especialidad <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="a_nombre" name="nombre" placeholder="Ej. Dermatología" required>
          </div>
          
          <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea class="form-control" id="a_descripcion" name="descripcion" rows="3" placeholder="Breve descripción del área médica..."></textarea>
          </div>

          <div class="form-group">
            <label class="form-label">Estatus</label>
            <select class="form-select" id="a_activo" name="activo" required>
              <option value="1" selected>Activo (Visible para agendar)</option>
              <option value="0">Inactivo (Oculto)</option>
            </select>
          </div>
          
          <div class="modal-footer-buttons">
            <button type="button" class="btn-cancelar" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn-guardar"><i class="icofont icofont-save"></i> Guardar Especialidad</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal EDITAR especialidad -->
<div class="modal fade custom-modal" id="modalEditarEspecialidad" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header editar-header">
        <h5 class="modal-title"><i class="icofont icofont-ui-edit me-2"></i> Editar Especialidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_editar_especialidad" method="POST">
          <input type="hidden" id="e_id_especialidad" name="id_especialidad">
          
          <div class="form-group">
            <label class="form-label">Nombre de la Especialidad <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="e_nombre" name="nombre" required>
          </div>
          
          <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea class="form-control" id="e_descripcion" name="descripcion" rows="3"></textarea>
          </div>

          <div class="form-group">
            <label class="form-label">Estatus</label>
            <select class="form-select" id="e_activo" name="activo" required>
              <option value="1">Activo (Visible para agendar)</option>
              <option value="0">Inactivo (Oculto)</option>
            </select>
          </div>
          
          <div class="modal-footer-buttons">
            <button type="button" class="btn-cancelar" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn-actualizar"><i class="icofont icofont-refresh"></i> Actualizar Especialidad</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Agregar especialidad
    $('#form_agregar_especialidad').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '_actions/create_especialidad.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('#modalAgregarEspecialidad').modal('hide');
                    $('#form_agregar_especialidad')[0].reset();
                    $('#tbl_especialidades').DataTable().ajax.reload();
                    
                    Swal.fire({
                        icon: 'success',
                        title: '¡Guardado!',
                        text: 'Especialidad guardada correctamente.',
                        confirmButtonColor: '#2c7da0',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo guardar la especialidad.',
                        confirmButtonColor: '#d33'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo conectar con el servidor. Inténtalo de nuevo.',
                    confirmButtonColor: '#d33'
                });
            }
        });
    });

    // Editar especialidad
    $('#form_editar_especialidad').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '_actions/update_especialidad.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('#modalEditarEspecialidad').modal('hide');
                    $('#tbl_especialidades').DataTable().ajax.reload();
                    
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: 'Especialidad actualizada correctamente.',
                        confirmButtonColor: '#e6a017',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo actualizar la especialidad.',
                        confirmButtonColor: '#d33'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudo conectar con el servidor. Inténtalo de nuevo.',
                    confirmButtonColor: '#d33'
                });
            }
        });
    });
});

// Función global para editar (se mantiene exactamente igual)
function editarEspecialidad(id, nombre, descripcion, activo) {
    $('#e_id_especialidad').val(id);
    $('#e_nombre').val(nombre);
    $('#e_descripcion').val(descripcion);
    $('#e_activo').val(activo);
}
</script>