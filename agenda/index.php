<?php
require_once __DIR__ . '/../_config/runtime.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Agenda tu cita m�dica</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/icon/themify-icons/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="../assets/icon/icofont/css/icofont.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/StyleCita.css">
    <link rel="stylesheet" type="text/css" href="../assets/timepicker/jquery.datetimepicker.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        <!-- Elementos decorativos -->
        <div class="bg-decoration">
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <div class="orb orb-3"></div>
        </div>
        
        <!-- Ondas animadas -->
        <div class="waves">
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
        
        <!-- Estrellas -->
        <div class="stars" id="stars"></div>

        <div class="main-container">
            <div class="appointment-card-elegant">
                <div class="card-header-elegant">
                    <h2><i class="fas fa-calendar-plus" style="margin-right: 12px;"></i>Agendar Cita Médica</h2>
                    <p>Completa el formulario para solicitar tu cita de manera rápida y sencilla</p>
                </div>

                <div class="card-body-elegant">
                    <!-- Formulario de registro -->
                    <div id="registro">
                        <form>
                            <div class="form-grid">
                                <div class="form-group-elegant">
                                    <label><i class="fas fa-id-card"></i> CURP (Opcional)</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-id-card input-icon"></i>
                                        <input type="text" id="curp" name="curp" class="input-field-elegant" placeholder="CURP" maxlength="18" onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>

                                <div class="form-group-elegant">
                                    <label><i class="fas fa-user"></i> Nombre Completo *</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-user input-icon"></i>
                                        <input type="text" id="nombre_completo" name="nombre_completo" class="input-field-elegant" placeholder="Nombre completo" required>
                                    </div>
                                </div>

                                <div class="form-group-elegant">
                                    <label><i class="fas fa-phone"></i> Teléfono *</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-phone input-icon"></i>
                                        <input type="number" id="telefono" name="telefono" class="input-field-elegant" placeholder="10 dígitos" maxlength="10" onKeyDown="limitText(this,10);" onKeyUp="limitText(this,10);" required>
                                    </div>
                                </div>

                                <div class="form-group-elegant">
                                    <label><i class="fas fa-envelope"></i> Correo Electrónico</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-envelope input-icon"></i>
                                        <input type="email" id="correo" name="correo" class="input-field-elegant" placeholder="correo@ejemplo.com">
                                    </div>
                                </div>

                                <div class="form-group-elegant">
                                    <label><i class="fas fa-stethoscope"></i> Especialidad *</label>
                                    <select class="form-control" id="especialidad" name="especialidad" required style="width: 100%;">
                                        <option value="">Seleccione especialidad</option>
                                    </select>
                                </div>

                                <div class="form-group-elegant">
                                    <label><i class="fas fa-user-md"></i> Médico *</label>
                                    <select class="form-control" id="medico" name="medico" required style="width: 100%;">
                                        <option value="">Primero seleccione especialidad</option>
                                    </select>
                                </div>

                                <div class="form-group-elegant">
                                    <label><i class="fas fa-clinic-medical"></i> Tipo de Servicio *</label>
                                    <select class="form-control" id="servicio" name="servicio" required style="width: 100%;">
                                        <option value="">Seleccione tipo de servicio</option>
                                    </select>
                                </div>

                                <div class="form-group-elegant">
                                    <label><i class="fas fa-calendar-day"></i> Fecha *</label>
                                    <div class="input-icon-wrapper">
                                        <i class="fas fa-calendar-alt input-icon"></i>
                                        <input type="text" id="fecha_cita" name="fecha_cita" class="input-field-elegant datetimepicker" placeholder="Seleccione fecha" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="form-group-elegant">
                                    <label><i class="fas fa-clock"></i> Hora *</label>
                                    <select class="form-control" id="hora_cita" name="hora_cita" required style="width: 100%;">
                                        <option value="">Seleccione fecha y médico</option>
                                    </select>
                                </div>

                                <div class="full-width form-group-elegant">
                                    <label><i class="fas fa-notes-medical"></i> Motivo de la Cita *</label>
                                    <textarea id="motivo" name="motivo" class="input-field-elegant" rows="3" placeholder="Breve descripción del síntoma o motivo de la consulta..."></textarea>
                                </div>
                            </div>

                            <label class="checkbox-elegant">
                                <input type="checkbox" id="check" name="check">
                                <span>Confirmo que la información proporcionada es verdadera y acepto los términos y condiciones.</span>
                            </label>

                            <button type="button" id="btn_registro" class="btn-submit-elegant">
                                <i class="fas fa-check-circle"></i> Confirmar Cita
                            </button>
<!-- 
                            <a href="login.html" class="btn-back-elegant">
                                <i class="fas fa-arrow-left"></i> Volver al inicio
                            </a> -->
                        </form>
                    </div>

                    <!-- Mensaje de éxito -->
                    <div id="formato" style="display:none;">
                        <div class="success-message">
                            <i class="fas fa-check-circle"></i>
                            <h3>¡Cita registrada exitosamente!</h3>
                            <p>Tu cita ha sido agendada. Recibirás un correo de confirmación con los detalles.</p>
                            <button type="button" id="btn_nueva_cita" class="btn-submit-elegant" style="margin-top: 20px;">
                                <i class="fas fa-plus-circle"></i> Registrar otra cita
                            </button>
                        </div>
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

    function createStars() {
        const starsContainer = document.getElementById('stars');
        const starCount = 80;
        
        for (let i = 0; i < starCount; i++) {
            const star = document.createElement('div');
            star.classList.add('star');
            const size = Math.random() * 3 + 1;
            star.style.width = size + 'px';
            star.style.height = size + 'px';
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * 100 + '%';
            star.style.animationDelay = Math.random() * 5 + 's';
            star.style.animationDuration = Math.random() * 3 + 2 + 's';
            starsContainer.appendChild(star);
        }
    }

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
                            correoInfo = "<p class='m-t-10 text-success'>Te enviamos un correo de confirmaci�n.</p>";
                        } else if (resultado.mail_sent === false) {
                            correoInfo = "<p class='m-t-10 text-warning'>La cita se guard�, pero el correo de confirmaci�n no pudo enviarse.</p>";
                        }

                        $("#formato").html(
                            "<h3 class='text-success'><i class='icofont icofont-check-circled'></i> Cita registrada</h3>" +
                            "<p class='m-t-15'>Tu cita qued� agendada exitosamente para el <strong>" + datos.fecha + "</strong>.</p>" +
                            correoInfo +
                            "<div class='m-t-20'><button type='button' id='btn_nueva_cita' class='btn btn-outline-primary waves-effect'>Registrar otra cita</button></div>"
                        );
                        $("#formato").show();
                        $("#registro").hide();
                    } else {
                        alert("Fall� el registro: " + resultado.message);
                    }
                },
                error: function(xhr,desc,err){
                    console.log("Error de conexi�n");
                }
            });
        } else {
            alert("Debe completar todos los campos obligatorios (incluyendo especialidad y servicio) y marcar la casilla de confirmaci�n.");
        }
    });
    </script>
</body>
</html>
