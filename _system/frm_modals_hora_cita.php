<div class="modal fade" id="modalAgregarHoraCita" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white"><i class="icofont icofont-plus"></i> Agregar Bloque de Horario</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="form_agregar_hora_cita" method="POST">
          <div class="row">
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Hora de inicio <span class="text-danger">*</span></label>
              <input type="time" class="form-control" id="a_hora_inicio" name="hora_inicio" required>
            </div>
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Hora de fin <span class="text-danger">*</span></label>
              <input type="time" class="form-control" id="a_hora_fin" name="hora_fin" required>
            </div>
          </div>

          <div class="form-group">
            <label class="font-weight-bold">Etiqueta</label>
            <input type="text" class="form-control" id="a_etiqueta" name="etiqueta" placeholder="Ej. 13:00 - 13:30">
          </div>

          <div class="row">
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Turno</label>
              <select class="form-control" id="a_turno" name="turno">
                <option value="">Detectar automáticamente</option>
                <option value="Matutino">Matutino</option>
                <option value="Vespertino">Vespertino</option>
              </select>
            </div>
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Estatus</label>
              <select class="form-control" name="activo">
                <option value="1" selected>Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>
          </div>

          <div class="text-right m-t-20">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary"><i class="icofont icofont-save"></i> Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalEditarHoraCita" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title text-dark"><i class="icofont icofont-ui-edit"></i> Editar Bloque de Horario</h5>
        <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="form_editar_hora_cita" method="POST">
          <input type="hidden" id="e_id_hora" name="id_hora">

          <div class="row">
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Hora de inicio <span class="text-danger">*</span></label>
              <input type="time" class="form-control" id="e_hora_inicio" name="hora_inicio" required>
            </div>
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Hora de fin <span class="text-danger">*</span></label>
              <input type="time" class="form-control" id="e_hora_fin" name="hora_fin" required>
            </div>
          </div>

          <div class="form-group">
            <label class="font-weight-bold">Etiqueta</label>
            <input type="text" class="form-control" id="e_etiqueta" name="etiqueta">
          </div>

          <div class="row">
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Turno</label>
              <select class="form-control" id="e_turno" name="turno">
                <option value="">Detectar automáticamente</option>
                <option value="Matutino">Matutino</option>
                <option value="Vespertino">Vespertino</option>
              </select>
            </div>
            <div class="col-md-6 form-group">
              <label class="font-weight-bold">Estatus</label>
              <select class="form-control" id="e_activo" name="activo">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>
          </div>

          <div class="text-right m-t-20">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-warning"><i class="icofont icofont-refresh"></i> Actualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
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
    $('#a_hora_inicio, #a_hora_fin').on('change', autollenarEtiquetaAgregar);
    $('#e_hora_inicio, #e_hora_fin').on('change', autollenarEtiquetaEditar);

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
            alert('Horario guardado correctamente.');
          } else {
            alert('Error: ' + response.message);
          }
        },
        error: function () {
          alert('Error de conexión con el servidor.');
        }
      });
    });

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
            alert('Horario actualizado correctamente.');
          } else {
            alert('Error: ' + response.message);
          }
        },
        error: function () {
          alert('Error de conexión con el servidor.');
        }
      });
    });
  });
</script>
