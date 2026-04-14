<!-- ==================== ESTILOS MODERNOS ==================== -->
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

  /* Grid interno de dos columnas (reemplaza row/col) */
  .form-grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
  }

  @media (max-width: 576px) {
    .form-grid-2 {
      grid-template-columns: 1fr;
      gap: 0.5rem;
    }
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

<!-- ==================== MODAL AGREGAR MÉDICO ==================== -->
<div class="modal fade custom-modal" id="modalAgregarMedico" tabindex="-1" role="dialog" aria-labelledby="modalAgregarMedicoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="icofont icofont-plus-circle me-2"></i> Agregar Nuevo Médico</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_agregar_medico" method="POST">
          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label">Nombre Completo <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="a_nombre" name="nombre_completo" placeholder="Ej. Dr. Juan Pérez" required>
            </div>
            <div class="form-group">
              <label class="form-label">Cédula Profesional <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="a_cedula" name="cedula_profesional" placeholder="Ej. CED123456" required>
            </div>
          </div>

          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label">Especialidad <span class="text-danger">*</span></label>
              <select class="form-select" id="a_especialidad" name="id_especialidad" required>
                <option value="">Cargando especialidades...</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Consultorio Asignado</label>
              <select class="form-select" id="a_consultorio" name="id_consultorio">
                <option value="">Cargando consultorios...</option>
              </select>
            </div>
          </div>

          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label">Teléfono</label>
              <input type="text" class="form-control" id="a_telefono" name="telefono" placeholder="10 dígitos" maxlength="10">
            </div>
            <div class="form-group">
              <label class="form-label">Correo Electrónico</label>
              <input type="email" class="form-control" id="a_correo" name="correo" placeholder="doctor@clinica.com">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Estatus</label>
            <select class="form-select" id="a_activo" name="activo" required>
              <option value="1" selected>Activo (Disponible en agenda)</option>
              <option value="0">Inactivo (Vacaciones / Baja)</option>
            </select>
          </div>

          <div class="modal-footer-buttons">
            <button type="button" class="btn-cancelar" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn-guardar"><i class="icofont icofont-save"></i> Guardar Médico</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ==================== MODAL EDITAR MÉDICO ==================== -->
<div class="modal fade custom-modal" id="modalEditarMedico" tabindex="-1" role="dialog" aria-labelledby="modalEditarMedicoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header editar-header">
        <h5 class="modal-title"><i class="icofont icofont-ui-edit me-2"></i> Editar Médico</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_editar_medico" method="POST">
          <input type="hidden" id="e_id_medico" name="id_medico">

          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label">Nombre Completo <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="e_nombre" name="nombre_completo" required>
            </div>
            <div class="form-group">
              <label class="form-label">Cédula Profesional <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="e_cedula" name="cedula_profesional" required>
            </div>
          </div>

          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label">Especialidad <span class="text-danger">*</span></label>
              <select class="form-select" id="e_especialidad" name="id_especialidad" required>
                <!-- Se llena dinámicamente -->
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Consultorio Asignado</label>
              <select class="form-select" id="e_consultorio" name="id_consultorio">
                <!-- Se llena dinámicamente -->
              </select>
            </div>
          </div>

          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label">Teléfono</label>
              <input type="text" class="form-control" id="e_telefono" name="telefono" maxlength="10">
            </div>
            <div class="form-group">
              <label class="form-label">Correo Electrónico</label>
              <input type="email" class="form-control" id="e_correo" name="correo">
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Estatus</label>
            <select class="form-select" id="e_activo" name="activo" required>
              <option value="1">Activo (Disponible en agenda)</option>
              <option value="0">Inactivo (Vacaciones / Baja)</option>
            </select>
          </div>

          <div class="modal-footer-buttons">
            <button type="button" class="btn-cancelar" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn-actualizar"><i class="icofont icofont-refresh"></i> Actualizar Médico</button>
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
    cargarSelectsDinamicos();

    // Agregar médico
    $('#form_agregar_medico').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '_actions/create_medico.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('#modalAgregarMedico').modal('hide');
                    $('#form_agregar_medico')[0].reset();
                    $('#tbl_medicos').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Guardado!',
                        text: 'Médico guardado correctamente.',
                        confirmButtonColor: '#2c7da0',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo guardar el médico.',
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

    // Editar médico
    $('#form_editar_medico').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '_actions/update_medico.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('#modalEditarMedico').modal('hide');
                    $('#tbl_medicos').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: 'Médico actualizado correctamente.',
                        confirmButtonColor: '#e6a017',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo actualizar el médico.',
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

// Función para cargar especialidades y consultorios (idéntica a la original)
function cargarSelectsDinamicos() {
    $.getJSON('_actions/get_especialidades.php', function(data) {
        let opciones = '<option value="">Seleccione una especialidad...</option>';
        $.each(data, function(index, item) {
            opciones += `<option value="${item.id_especialidad}">${item.nombre}</option>`;
        });
        $('#a_especialidad').html(opciones);
        $('#e_especialidad').html(opciones);
    });

    $.getJSON('_actions/get_consultorios.php', function(data) {
        let opciones = '<option value="">Sin consultorio asignado (Opcional)</option>';
        $.each(data, function(index, item) {
            opciones += `<option value="${item.id_consultorio}">${item.numero_sala} - ${item.ubicacion}</option>`;
        });
        $('#a_consultorio').html(opciones);
        $('#e_consultorio').html(opciones);
    });
}
</script>