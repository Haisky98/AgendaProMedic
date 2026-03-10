<div class="modal fade" id="modalAgregarEspecialidad" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="modalAgregarLabel"><i class="icofont icofont-plus"></i> Agregar Nueva Especialidad</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_agregar_especialidad" method="POST">
                    <div class="form-group">
                        <label for="a_nombre" class="font-weight-bold">Nombre de la Especialidad <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="a_nombre" name="nombre" placeholder="Ej. Dermatología" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="a_descripcion" class="font-weight-bold">Descripción</label>
                        <textarea class="form-control" id="a_descripcion" name="descripcion" rows="3" placeholder="Breve descripción del área médica..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="a_activo" class="font-weight-bold">Estatus</label>
                        <select class="form-control" id="a_activo" name="activo" required>
                            <option value="1" selected>Activo (Visible para agendar)</option>
                            <option value="0">Inactivo (Oculto)</option>
                        </select>
                    </div>
                    
                    <div class="text-right m-t-20">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="icofont icofont-save"></i> Guardar Especialidad</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarEspecialidad" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark" id="modalEditarLabel"><i class="icofont icofont-ui-edit"></i> Editar Especialidad</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_editar_especialidad" method="POST">
                    <input type="hidden" id="e_id_especialidad" name="id_especialidad">
                    
                    <div class="form-group">
                        <label for="e_nombre" class="font-weight-bold">Nombre de la Especialidad <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="e_nombre" name="nombre" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="e_descripcion" class="font-weight-bold">Descripción</label>
                        <textarea class="form-control" id="e_descripcion" name="descripcion" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="e_activo" class="font-weight-bold">Estatus</label>
                        <select class="form-control" id="e_activo" name="activo" required>
                            <option value="1">Activo (Visible para agendar)</option>
                            <option value="0">Inactivo (Oculto)</option>
                        </select>
                    </div>
                    
                    <div class="text-right m-t-20">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning"><i class="icofont icofont-refresh"></i> Actualizar Especialidad</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    
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
        
                    alert("Especialidad guardada correctamente.");
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function() {
                alert("Error de conexión con el servidor.");
            }
        });
    });

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
                    alert("Especialidad actualizada correctamente.");
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function() {
                alert("Error de conexión con el servidor.");
            }
        });
    });

});

function editarEspecialidad(id, nombre, descripcion, activo) {
    $('#e_id_especialidad').val(id);
    $('#e_nombre').val(nombre);
    $('#e_descripcion').val(descripcion);
    $('#e_activo').val(activo);
}
</script>