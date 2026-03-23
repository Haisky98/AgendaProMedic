<?php
require_once __DIR__ . '/_class/session_helper.php';
agp_require_auth_page('login.php');

$nombre_usuario = $_SESSION['nombre'];
include_once('template/head.php');
?>
    <!-- CONTENEDOR PRINCIPAL -->
    <div class="container col-md-offset-3">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <!-- FORMULARIO -->
                <div class="row justify-content-center mt-5">
                    <div class="col-md-12">
                        <div class="card shadow p-5">
                            <h2 class="text-center mb-4 text-gray-900">Actualizar Contraseña</h2>
                            <form method="post" id="form_actualizar_password">

                                <div class="form-group mb-4">
                                    <label for="actual" class="form-label">Contraseña Actual</label>
                                    <div class="input-container">
                                        <input type="password" name="actual" id="actual" class="form-control bg-transparent" placeholder="Contraseña Actual" required>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="nueva" class="form-label">Nueva Contraseña</label>
                                    <div class="input-container">
                                        <input type="password" name="nueva" id="nueva" class="form-control bg-transparent" placeholder="Nueva Contraseña" required>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="confirmar" class="form-label">Confirmar Nueva Contraseña</label>
                                    <div class="input-container">
                                        <input type="password" name="confirmar" id="confirmar" class="form-control bg-transparent" placeholder="Confirmar Contraseña" required>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        Actualizar Contraseña
                                    </button>
                                </div>

                                <div class="text-center mt-3" id="mensaje_resultado"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- FIN FORMULARIO -->

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script>
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "4000"
            };

            $('#form_actualizar_password').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: '_actions/actualizar_contrasena.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === '1') {
                            toastr.success(response.mensaje);
                            $('#form_actualizar_password')[0].reset();
                            window.close();
                        } else {
                            toastr.error(response.mensaje);
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error inesperado al actualizar la contraseña.');
                        console.error(error);
                    }
                });
            });
        });
    </script>

</body>
