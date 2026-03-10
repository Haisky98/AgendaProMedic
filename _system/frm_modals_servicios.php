<div class="modal fade" id="modalAgregarServicio" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white"><i class="icofont icofont-plus"></i> Agregar Nuevo Servicio</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="form_agregar_servicio" method="POST">
                    <div class="form-group">
                        <label class="font-weight-bold">Especialidad <span class="text-danger">*</span></label>
                        <select class="form-control" id="a_id_especialidad" name="id_especialidad" required>
                            <option value="">Cargando especialidades...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Nombre del Servicio <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ej. Consulta General" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Duración (Minutos) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="duracion_estimada_minutos" value="30" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Costo ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="costo" value="0.00" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Estatus</label>
                        <select class="form-control" name="activo" required>
                            <option value="1" selected>Activo (Visible)</option>
                            <option value="0">Inactivo (Oculto)</option>
                        </select>
                    </div>
                    <div class="text-right m-t-20">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="icofont icofont-save"></i> Guardar Servicio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarServicio" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark"><i class="icofont icofont-ui-edit"></i> Editar Servicio</h5>
                <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="form_editar_servicio" method="POST">
                    <input type="hidden" id="e_id_servicio" name="id_servicio">
                    <div class="form-group">
                        <label class="font-weight-bold">Especialidad <span class="text-danger">*</span></label>
                        <select class="form-control" id="e_id_especialidad" name="id_especialidad" required>
                            <option value="">Cargando especialidades...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Nombre del Servicio <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="e_nombre" name="nombre" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Duración (Minutos) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="e_duracion" name="duracion_estimada_minutos" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">Costo ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" id="e_costo" name="costo" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Estatus</label>
                        <select class="form-control" id="e_activo" name="activo" required>
                            <option value="1">Activo (Visible)</option>
                            <option value="0">Inactivo (Oculto)</option>
                        </select>
                    </div>
                    <div class="text-right m-t-20">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning"><i class="icofont icofont-refresh"></i> Actualizar Servicio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function cargarEspecialidadesServicios() {
        $.getJSON('_actions/get_especialidades.php', function(data) {
            const opciones = ['<option value=\"\">Seleccione especialidad</option>'];
            $.each(data || [], function(_, item) {
                opciones.push(`<option value=\"${item.id_especialidad}\">${item.nombre}</option>`);
            });

            $('#a_id_especialidad').html(opciones.join(''));
            $('#e_id_especialidad').html(opciones.join(''));
        });
    }

    cargarEspecialidadesServicios();

    $('#form_agregar_servicio').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '_actions/create_servicio.php', type: 'POST', data: $(this).serialize(), dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('#modalAgregarServicio').modal('hide'); $('#form_agregar_servicio')[0].reset();
                    $('#tbl_servicios').DataTable().ajax.reload(); alert("Servicio guardado.");
                } else { alert("Error: " + response.message); }
            }
        });
    });

    $('#form_editar_servicio').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '_actions/update_servicio.php', type: 'POST', data: $(this).serialize(), dataType: 'json',
            success: function(response) {
                if(response.success) {
                    $('#modalEditarServicio').modal('hide'); $('#tbl_servicios').DataTable().ajax.reload(); alert("Servicio actualizado.");
                } else { alert("Error: " + response.message); }
            }
        });
    });
});
</script>
