<!-- ==================== ESTILOS MODERNOS (coherentes con el dashboard) ==================== -->
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

  /* Para inputs type time */
  .custom-modal input[type="time"] {
    padding: 0.7rem 1rem;
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

  .row.gap-2 {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
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
    .row.gap-2 {
      flex-direction: column;
      gap: 0;
    }
  }
</style>

<!-- ==================== MODAL AGREGAR BLOQUE DE HORARIO ==================== -->
<div class="modal fade custom-modal" id="modalAgregarHoraCita" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="icofont icofont-plus-circle me-2"></i> Agregar Bloque de Horario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="form_agregar_hora_cita" method="POST">
          <div class="row gap-2">
            <div class="col-md-6 form-group" style="flex: 1;">
              <label class="form-label">Hora de inicio <span class="text-danger">*</span></label>
              <input type="time" class="form-control" id="a_hora_inicio" name="hora_inicio" required>
            </div>
            <div class="col-md-6 form-group" style="flex: 1;">
              <label class="form-label">Hora de fin <span class="text-danger">*</span></label>
              <input type="time" class="form-control" id="a_hora_fin" name="hora_fin" required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Etiqueta</label>
            <input type="text" class="form-control" id="a_etiqueta" name="etiqueta" placeholder="Ej. 13:00 - 13:30">
          </div>

          <div class="row gap-2">
            <div class="col-md-6 form-group" style="flex: 1;">
              <label class="form-label">Turno</label>
              <select class="form-select" id="a_turno" name="turno">
                <option value="">Detectar automáticamente</option>
                <option value="Matutino">Matutino</option>
                <option value="Vespertino">Vespertino</option>
              </select>
            </div>
            <div class="col-md-6 form-group" style="flex: 1;">
              <label class="form-label">Estatus</label>
              <select class="form-select" name="activo">
                <option value="1" selected>Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>
          </div>

          <div class="modal-footer-buttons">
            <button type="button" class="btn-cancelar" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn-guardar"><i class="icofont icofont-save"></i> Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ==================== MODAL EDITAR BLOQUE DE HORARIO ==================== -->
<div class="modal fade custom-modal" id="modalEditarHoraCita" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header editar-header">
        <h5 class="modal-title"><i class="icofont icofont-ui-edit me-2"></i> Editar Bloque de Horario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="form_editar_hora_cita" method="POST">
          <input type="hidden" id="e_id_hora" name="id_hora">

          <div class="row gap-2">
            <div class="col-md-6 form-group" style="flex: 1;">
              <label class="form-label">Hora de inicio <span class="text-danger">*</span></label>
              <input type="time" class="form-control" id="e_hora_inicio" name="hora_inicio" required>
            </div>
            <div class="col-md-6 form-group" style="flex: 1;">
              <label class="form-label">Hora de fin <span class="text-danger">*</span></label>
              <input type="time" class="form-control" id="e_hora_fin" name="hora_fin" required>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Etiqueta</label>
            <input type="text" class="form-control" id="e_etiqueta" name="etiqueta">
          </div>

          <div class="row gap-2">
            <div class="col-md-6 form-group" style="flex: 1;">
              <label class="form-label">Turno</label>
              <select class="form-select" id="e_turno" name="turno">
                <option value="">Detectar automáticamente</option>
                <option value="Matutino">Matutino</option>
                <option value="Vespertino">Vespertino</option>
              </select>
            </div>
            <div class="col-md-6 form-group" style="flex: 1;">
              <label class="form-label">Estatus</label>
              <select class="form-select" id="e_activo" name="activo">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>
          </div>

          <div class="modal-footer-buttons">
            <button type="button" class="btn-cancelar" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn-actualizar"><i class="icofont icofont-refresh"></i> Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ==================== SCRIPT CON SWEETALERT2 Y FUNCIONES ==================== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Funciones auxiliares (se mantienen exactamente igual)
  function construirEtiqueta(inicio, fin) {
    if (!inicio || !fin) return '';
    return `${inicio} - ${fin}`;
  }

  function autollenarEtiquetaAgregar() {
    if (!$('#a_etiqueta').val().trim()) {
      $('#a_etiqueta').val(construirEtiqueta($('#a_hora_inicio').val(), $('#a_hora_fin').val()));
    }
  }

  function autollenarEtiquetaEditar() {
    if (!$('#e_etiqueta').val().trim()) {
      $('#e_etiqueta').val(construirEtiqueta($('#e_hora_inicio').val(), $('#e_hora_fin').val()));
    }
  }

  $(document).ready(function () {
    // Eventos para autollenar etiqueta
    $('#a_hora_inicio, #a_hora_fin').on('change', autollenarEtiquetaAgregar);
    $('#e_hora_inicio, #e_hora_fin').on('change', autollenarEtiquetaEditar);

    // Agregar bloque de horario
    $('#form_agregar_hora_cita').on('submit', function (e) {
      e.preventDefault();
      $.ajax({
        url: '_actions/create_hora_cita.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            $('#modalAgregarHoraCita').modal('hide');
            $('#form_agregar_hora_cita')[0].reset();
            $('#tbl_horas_cita').DataTable().ajax.reload();
            Swal.fire({
              icon: 'success',
              title: '¡Guardado!',
              text: 'Horario guardado correctamente.',
              confirmButtonColor: '#2c7da0',
              timer: 2000,
              showConfirmButton: false
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: response.message || 'No se pudo guardar el horario.',
              confirmButtonColor: '#d33'
            });
          }
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'No se pudo conectar con el servidor.',
            confirmButtonColor: '#d33'
          });
        }
      });
    });

    // Editar bloque de horario
    $('#form_editar_hora_cita').on('submit', function (e) {
      e.preventDefault();
      $.ajax({
        url: '_actions/update_hora_cita.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            $('#modalEditarHoraCita').modal('hide');
            $('#tbl_horas_cita').DataTable().ajax.reload();
            Swal.fire({
              icon: 'success',
              title: '¡Actualizado!',
              text: 'Horario actualizado correctamente.',
              confirmButtonColor: '#e6a017',
              timer: 2000,
              showConfirmButton: false
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: response.message || 'No se pudo actualizar el horario.',
              confirmButtonColor: '#d33'
            });
          }
        },
        error: function () {
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
</script>