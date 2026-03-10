<div class="modal fade" id="modalAgregarMedico" tabindex="-1" role="dialog" aria-labelledby="modalAgregarMedicoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="modalAgregarMedicoLabel"><i class="icofont icofont-plus"></i> Agregar Nuevo Médico</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_agregar_medico" method="POST">
                    <div class="row">
                        <div class="col-md-8 form-group">
                            <label for="a_nombre" class="font-weight-bold">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="a_nombre" name="nombre_completo" placeholder="Ej. Dr. Juan Pérez" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="a_cedula" class="font-weight-bold">Cédula Profesional <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="a_cedula" name="cedula_profesional" placeholder="Ej. CED123456" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="a_especialidad" class="font-weight-bold">Especialidad <span class="text-danger">*</span></label>
                            <select class="form-control" id="a_especialidad" name="id_especialidad" required>
                                <option value="">Cargando especialidades...</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="a_consultorio" class="font-weight-bold">Consultorio Asignado</label>
                            <select class="form-control" id="a_consultorio" name="id_consultorio">
                                <option value="">Cargando consultorios...</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="a_telefono" class="font-weight-bold">Teléfono</label>
                            <input type="text" class="form-control" id="a_telefono" name="telefono" placeholder="10 dígitos" maxlength="10">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="a_correo" class="font-weight-bold">Correo Electrónico</label>
                            <input type="email" class="form-control" id="a_correo" name="correo" placeholder="doctor@clinica.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="a_activo" class="font-weight-bold">Estatus</label>
                        <select class="form-control" id="a_activo" name="activo" required>
                            <option value="1" selected>Activo (Disponible en agenda)</option>
                            <option value="0">Inactivo (Vacaciones / Baja)</option>
                        </select>
                    </div>
                    
                    <div class="text-right m-t-20">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="icofont icofont-save"></i> Guardar Médico</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarMedico" tabindex="-1" role="dialog" aria-labelledby="modalEditarMedicoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark" id="modalEditarMedicoLabel"><i class="icofont icofont-ui-edit"></i> Editar Médico</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_editar_medico" method="POST">
                    <input type="hidden" id="e_id_medico" name="id_medico">
                    
                    <div class="row">
                        <div class="col-md-8 form-group">
                            <label for="e_nombre" class="font-weight-bold">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="e_nombre" name="nombre_completo" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="e_cedula" class="font-weight-bold">Cédula Profesional <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="e_cedula" name="cedula_profesional" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="e_especialidad" class="font-weight-bold">Especialidad <span class="text-danger">*</span></label>
                            <select class="form-control" id="e_especialidad" name="id_especialidad" required>
                                </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="e_consultorio" class="font-weight-bold">Consultorio Asignado</label>
                            <select class="form-control" id="e_consultorio" name="id_consultorio">
                                </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="e_telefono" class="font-weight-bold">Teléfono</label>
                            <input type="text" class="form-control" id="e_telefono" name="telefono" maxlength="10">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="e_correo" class="font-weight-bold">Correo Electrónico</label>
                            <input type="email" class="form-control" id="e_correo" name="correo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="e_activo" class="font-weight-bold">Estatus</label>
                        <select class="form-control" id="e_activo" name="activo" required>
                            <option value="1">Activo (Disponible en agenda)</option>
                            <option value="0">Inactivo (Vacaciones / Baja)</option>
                        </select>
                    </div>
                    
                    <div class="text-right m-t-20">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning"><i class="icofont icofont-refresh"></i> Actualizar Médico</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    cargarSelectsDinamicos();
 
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
                    alert("Médico guardado correctamente.");
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function() {
                alert("Error de conexión con el servidor.");
            }
        });
    });

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
                    alert("Médico actualizado correctamente.");
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