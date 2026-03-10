<div class="modal fade" id="modalAgregarConsultorio" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white"><i class="icofont icofont-plus"></i> Agregar Consultorio / Sala</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="form_agregar_consultorio" method="POST">
          <div class="form-group">
            <label class="font-weight-bold">Número/Sala <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="numero_sala" placeholder="Ej. Consultorio 5" required>
          </div>

          <div class="form-group">
            <label class="font-weight-bold">Ubicación <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="ubicacion" placeholder="Ej. Planta alta, ala norte" required>
          </div>

          <div class="form-group">
            <label class="font-weight-bold">Estatus</label>
            <select class="form-control" name="activo">
              <option value="1" selected>Activo</option>
              <option value="0">Inactivo</option>
            </select>
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

<div class="modal fade" id="modalEditarConsultorio" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title text-dark"><i class="icofont icofont-ui-edit"></i> Editar Consultorio / Sala</h5>
        <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="form_editar_consultorio" method="POST">
          <input type="hidden" id="e_id_consultorio" name="id_consultorio">

          <div class="form-group">
            <label class="font-weight-bold">Número/Sala <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="e_numero_sala" name="numero_sala" required>
          </div>

          <div class="form-group">
            <label class="font-weight-bold">Ubicación <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="e_ubicacion" name="ubicacion" required>
          </div>

          <div class="form-group">
            <label class="font-weight-bold">Estatus</label>
            <select class="form-control" id="e_activo_consultorio" name="activo">
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
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
  $(document).ready(function () {
    $('#form_agregar_consultorio').on('submit', function (e) {
      e.preventDefault();
      $.ajax({
        url: '_actions/create_consultorio.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            $('#modalAgregarConsultorio').modal('hide');
            $('#form_agregar_consultorio')[0].reset();
            $('#tbl_consultorios').DataTable().ajax.reload();
            alert('Consultorio guardado correctamente.');
          } else {
            alert('Error: ' + response.message);
          }
        },
        error: function () {
          alert('Error de conexión con el servidor.');
        }
      });
    });

    $('#form_editar_consultorio').on('submit', function (e) {
      e.preventDefault();
      $.ajax({
        url: '_actions/update_consultorio.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            $('#modalEditarConsultorio').modal('hide');
            $('#tbl_consultorios').DataTable().ajax.reload();
            alert('Consultorio actualizado correctamente.');
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
