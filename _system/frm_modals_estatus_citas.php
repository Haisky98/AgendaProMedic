<div class="modal fade" id="modalAgregarEstatus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white"><i class="icofont icofont-plus"></i> Agregar Nuevo Estatus</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="form_agregar_estatus" method="POST">
                    <div class="form-group">
                        <label class="font-weight-bold">Nombre del Estatus <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ej. En Sala de Espera" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Estado</label>
                        <select class="form-control" id="a_activo" name="activo" required>
                            <option value="1">Activo (Visible)</option>
                            <option value="0">Inactivo (Oculto)</option>
                        </select>
                    </div>
                    <div class="text-right m-t-20">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="icofont icofont-save"></i> Guardar Estatus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarEstatus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark"><i class="icofont icofont-ui-edit"></i> Editar Estatus</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="form_editar_estatus" method="POST">
                    <input type="hidden" id="e_id_estatus" name="id_estatus">
                    <div class="form-group">
                        <label class="font-weight-bold">Nombre del Estatus <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="e_nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Estado</label>
                        <select class="form-control" id="e_activo" name="activo" required>
                            <option value="1">Activo (Visible)</option>
                            <option value="0">Inactivo (Oculto)</option>
                        </select>
                    </div>
                    <div class="text-right m-t-20">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning"><i class="icofont icofont-refresh"></i> Actualizar Estatus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#form_agregar_estatus').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '_actions/create_estatus_cita.php', type: 'POST', data: $(this).serialize(), dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('#modalAgregarEstatus').modal('hide'); $('#form_agregar_estatus')[0].reset();
                    $('#tbl_estatus').DataTable().ajax.reload(); alert("Estatus guardado.");
                } else { alert("Error: " + response.message); }
            }
        });
    });

    $('#form_editar_estatus').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '_actions/update_estatus_cita.php', type: 'POST', data: $(this).serialize(), dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('#modalEditarEstatus').modal('hide'); $('#tbl_estatus').DataTable().ajax.reload(); alert("Estatus actualizado.");
                } else { alert("Error: " + response.message); }
            }
        });
    });
});
</script>
