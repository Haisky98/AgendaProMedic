<?php
require_once __DIR__ . '/../_config/runtime.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Agenda tu cita médica</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/icon/themify-icons/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="../assets/icon/icofont/css/icofont.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../assets/timepicker/jquery.datetimepicker.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            border: none !important;
            border-bottom: 1px solid #ccc !important;
            border-radius: 0 !important;
            padding: 6px 0 !important;
            height: auto !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered { 
            background-color: transparent !important; 
            color: #333 !important; 
            padding-left: 0 !important;
        }
        .select2-container--default.select2-container--focus .select2-selection--single { 
            box-shadow: none !important; 
            border-bottom: 2px solid #007bff !important; 
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 50% !important;
            transform: translateY(-50%) !important;
        }

        label { margin-bottom: 5px; font-weight: 600; }
    </style>
</head>

<body class="fix-menu">
    <section class="login p-fixed d-flex text-center bg-primary common-img-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-block auth-body mr-auto ml-auto">
                        <form class="md-float-material">
                            <div class="text-left">
                            </div>
                            <div class="auth-box" id="registro">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center txt-primary">Agendar Cita Médica</h3>
                                    </div>
                                </div>
                                <hr/>
                                
                                <div class="input-group">
                                    <input type="text" id="curp" name="curp" class="form-control" placeholder="CURP (Opcional)" maxlength="18" onkeyup="this.value = this.value.toUpperCase();">
                                    <span class="md-line"></span>
                                </div>
                                <div class="input-group">
                                    <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" placeholder="Nombre Completo" required>
                                    <span class="md-line"></span>
                                </div>
                                <div class="input-group">
                                    <input type="number" id="telefono" name="telefono" class="form-control" placeholder="Teléfono (10 dígitos)" maxlength="10" onKeyDown="limitText(this,10);" onKeyUp="limitText(this,10);" required>
                                    <span class="md-line"></span>
                                    
                                    <input type="email" id="correo" name="correo" class="form-control" placeholder="Correo electrónico">
                                    <span class="md-line"></span>
                                </div>

                                <div class="input-group">
                                    <select class="form-control" id="especialidad" name="especialidad" required style="width: 100%;">
                                        <option value="">Seleccione especialidad</option>
                                    </select>
                                    <span class="md-line"></span>
                                </div>
                                
                                <div class="input-group">
                                    <select class="form-control" id="medico" name="medico" required style="width: 100%;">
                                        <option value="">Primero seleccione especialidad</option>
                                    </select>
                                    <span class="md-line"></span>
                                </div>
                                
                                <div class="input-group">
                                    <select class="form-control" id="servicio" name="servicio" required style="width: 100%;">
                                        <option value="">Seleccione tipo de servicio</option>
                                    </select>
                                    <span class="md-line"></span>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="date" name="fecha_cita" id="fecha_cita" class="form-control datetimepicker" placeholder="Seleccione fecha" autocomplete="off" required>
                                            <span class="md-line"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <select class="form-control" id="hora_cita" name="hora_cita" required style="width: 100%;">
                                                <option value="">Seleccione fecha y médico</option>
                                            </select>
                                            <span class="md-line"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group m-t-15">
                                    <label for="motivo" class="text-left text-dark d-block">Motivo de la Cita:</label>
                                    <textarea id="motivo" name="motivo" class="form-control" rows="3" placeholder="Breve descripción del síntoma o motivo..." required></textarea>
                                    <span class="md-line"></span>
                                </div>

                                <div class="row m-t-25 text-left">
                                    <div class="col-md-12">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label>
                                                <input type="checkbox" id="check" name="check">
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span class="text-inverse">Confirmo que la información es verdadera.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="button" id="btn_registro" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Confirmar Cita</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="auth-box" id="formato" style="display:none; color: black; background-color: #fff; padding: 30px; border-radius: 5px;">
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript" src="../assets/js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/timepicker/jquery.datetimepicker.full.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#especialidad').select2({ placeholder: "Seleccione especialidad", allowClear: true });
        $('#medico').select2({ placeholder: "Seleccione un médico", allowClear: true });
        $('#servicio').select2({ placeholder: "Seleccione tipo de servicio", allowClear: true });
        $('#hora_cita').select2({ placeholder: "Seleccione horario", allowClear: true });
     
        $('#fecha_cita').datetimepicker({
            timepicker: false,
            format: 'Y-m-d',
            minDate: 0, 
            disabledWeekDays: [0], 
            onChangeDateTime: function(dp, $input){
                cargarHorariosDisponibles();
            }
        });
     
        cargarCatalogosIniciales();

        
        $('#especialidad').change(function() {
            var idEspecialidad = $(this).val();
            if(idEspecialidad) {
                $.ajax({
                    url: '../_actions/get_medicos.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { id_especialidad: idEspecialidad },
                    success: function(data) {
                        $('#medico').empty().append('<option value=""></option>');
                        $.each(data, function(index, med) {
                            $('#medico').append($('<option>', { value: med.id_medico, text: med.nombre_completo }));
                        });
                        cargarHorariosDisponibles(); 
                    }
                });

                cargarServiciosPorEspecialidad(idEspecialidad);
            } else {
                $('#medico').empty().append('<option value=""></option>');
                $('#servicio').empty().append('<option value="">Primero seleccione especialidad</option>').val(null).trigger('change');
            }
        });
       
        $('#medico').change(function() {
            cargarHorariosDisponibles();
        });

        $(document).on('click', '#btn_nueva_cita', function () {
            reiniciarFormularioCita();
        });
    });

    function cargarCatalogosIniciales() {
        $.getJSON('../_actions/get_especialidades.php', function(data) {
            $('#especialidad').empty().append('<option value=""></option>');
            $.each(data, function(index, esp) {
                $('#especialidad').append($('<option>', { value: esp.id_especialidad, text: esp.nombre }));
            });
        });

        $('#servicio').empty().append('<option value="">Primero seleccione especialidad</option>');
    }

    function cargarServiciosPorEspecialidad(idEspecialidad) {
        var $servicio = $('#servicio');

        if (!idEspecialidad) {
            $servicio.empty().append('<option value="">Primero seleccione especialidad</option>').val(null).trigger('change');
            return;
        }

        $servicio.empty().append('<option value="">Cargando servicios...</option>');

        $.ajax({
            url: '../_actions/get_servicios.php',
            type: 'POST',
            dataType: 'json',
            data: { id_especialidad: idEspecialidad },
            success: function(data) {
                $servicio.empty().append('<option value=""></option>');
                if (data.length > 0) {
                    $.each(data, function(index, serv) {
                        $servicio.append($('<option>', { value: serv.id_servicio, text: serv.nombre }));
                    });
                } else {
                    $servicio.append('<option value="">Sin servicios disponibles</option>');
                }
                $servicio.val(null).trigger('change');
            },
            error: function() {
                $servicio.empty().append('<option value="">Error al cargar servicios</option>');
            }
        });
    }

    function cargarHorariosDisponibles() {
        var fecha = $('#fecha_cita').val();
        var idMedico = $('#medico').val();
        var selectHora = $('#hora_cita');

        if (fecha && idMedico) {
            selectHora.empty().append('<option value="">Cargando horarios...</option>');
            
            $.ajax({
                url: '../_actions/get_horas_disponibles.php',
                type: 'POST',
                dataType: 'json',
                data: { fecha: fecha, id_medico: idMedico },
                success: function(data) {
                    selectHora.empty().append('<option value=""></option>');
                    if(data.length > 0) {
                        $.each(data, function(index, hora) {
                            selectHora.append($('<option>', { value: hora.id_hora, text: hora.etiqueta }));
                        });
                    } else {
                        selectHora.append($('<option>', { value: "", text: "Sin horarios disponibles" }));
                    }
                }
            });
        } else {
            selectHora.empty().append('<option value=""></option>');
        }
    }

    function limitText(limitField, limitNum) {
        if (limitField.value.length > limitNum) {
            limitField.value = limitField.value.substring(0, limitNum);
        }
    }

    function reiniciarFormularioCita() {
        $('#curp').val('');
        $('#nombre_completo').val('');
        $('#telefono').val('');
        $('#correo').val('');
        $('#motivo').val('');
        $('#check').prop('checked', false);

        $('#especialidad').val(null).trigger('change');
        $('#medico').empty().append('<option value="">Primero seleccione especialidad</option>').val(null).trigger('change');
        $('#servicio').val(null).trigger('change');
        $('#fecha_cita').val('');
        $('#hora_cita').empty().append('<option value="">Seleccione fecha y médico</option>').val(null).trigger('change');

        $('#formato').hide().empty();
        $('#registro').show();
    }

    // Guardar Cita
    $("#btn_registro").click(function(){
        if($("#check").is(':checked') && $("#nombre_completo").val() && $("#telefono").val() && $("#medico").val() && $("#servicio").val() && $("#fecha_cita").val() && $("#hora_cita").val()) {
            
            var datos = {
                curp: $("#curp").val(),
                nombre: $("#nombre_completo").val(),
                telefono: $("#telefono").val(),
                correo: $("#correo").val(),
                id_medico: $("#medico").val(),
                id_servicio: $("#servicio").val(),
                fecha: $("#fecha_cita").val(),
                id_hora: $("#hora_cita").val(),
                motivo: $("#motivo").val()
            };
            
            $.ajax({
                url: '../_actions/insert_cita.php',
                type: 'POST',
                dataType: 'json',
                data: datos,
                success: function (resultado) {
                    if (resultado.success) {
                        var correoInfo = "";
                        if (resultado.mail_sent === true) {
                            correoInfo = "<p class='m-t-10 text-success'>Te enviamos un correo de confirmación.</p>";
                        } else if (resultado.mail_sent === false) {
                            correoInfo = "<p class='m-t-10 text-warning'>La cita se guardó, pero el correo de confirmación no pudo enviarse.</p>";
                        }

                        $("#formato").html(
                            "<h3 class='text-success'><i class='icofont icofont-check-circled'></i> Cita registrada</h3>" +
                            "<p class='m-t-15'>Tu cita quedó agendada exitosamente para el <strong>" + datos.fecha + "</strong>.</p>" +
                            correoInfo +
                            "<div class='m-t-20'><button type='button' id='btn_nueva_cita' class='btn btn-outline-primary waves-effect'>Registrar otra cita</button></div>"
                        );
                        $("#formato").show();
                        $("#registro").hide();
                    } else {
                        alert("Falló el registro: " + resultado.message);
                    }
                },
                error: function(xhr,desc,err){
                    console.log("Error de conexión");
                }
            });
        } else {
            alert("Debe completar todos los campos obligatorios (incluyendo especialidad y servicio) y marcar la casilla de confirmación.");
        }
    });
    </script>
</body>
</html>
