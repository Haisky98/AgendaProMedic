<?php
require_once __DIR__ . '/_class/session_helper.php';
agp_session_start();

if (agp_is_authenticated()) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Agenda Pro Medic</title>
    <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="CodedThemes">
    <meta name="keywords" content=" Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="CodedThemes">
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/StyleLogin.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
</head>

<body class="fix-menu">
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
                <div class="ring"><div class="frame"></div></div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->

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
        
        <!-- Estrellas brillantes -->
        <div class="stars" id="stars"></div>

        <div class="main-container">
            <div class="login-card-elegant">
                <div class="card-header-elegant">
                    <div class="logo-wrapper">
                        <img src="assets/images/logo-png.png" alt="Agenda Pro Medic">
                    </div>
                    <h2>Bienvenido de vuelta</h2>
                    <p>Ingresa tus credenciales para acceder al sistema</p>
                </div>
                
                <div class="card-body-elegant">
                    <form class="md-float-material">
                        <div class="form-group-elegant">
                            <label>
                                <i class="fas fa-user-circle" style="margin-right: 8px;"></i>
                                Usuario
                            </label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" name="usuario" id="usuario" class="input-field-elegant" placeholder="Ingresa tu usuario" autocomplete="off">
                                <span class="md-line"></span>
                            </div>
                        </div>
                        
                        <div class="form-group-elegant">
                            <label>
                                <i class="fas fa-lock" style="margin-right: 8px;"></i>
                                Contraseña
                            </label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-key input-icon"></i>
                                <input type="password" name="password" id="password" class="input-field-elegant" placeholder="Ingresa tu contraseña">
                                <span class="md-line"></span>
                            </div>
                            <!-- <div class="help-link">
                                <a href="#">
                                    <i class="fas fa-question-circle"></i> ¿Olvidaste tu contraseña?
                                </a>
                            </div> -->
                        </div>
                        
                        <button type="button" id="btn_login" class="btn-login-elegant">
                            <i class="fas fa-arrow-right-to-bracket"></i>
                            Iniciar Sesión
                        </button>
                        
                        <div class="divider-elegant">
                            <span>¿Necesitas una cita?</span>
                        </div>
                        
                        <a href="agenda/" class="btn-appointment-elegant">
                            <i class="fas fa-calendar-check"></i>
                            Agendar Cita
                        </a>
                    </form>
                    <!-- end of form -->
                </div>
            </div>
        </div>
    </section>
    
    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
    <!--[if lt IE 9]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    

    <script type="text/javascript" src="assets/js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="assets/js/modernizr/modernizr.js"></script>
    <script type="text/javascript" src="assets/js/modernizr/css-scrollbars.js"></script>
    <script type="text/javascript" src="assets/js/common-pages.js"></script>


    <script>

            // Crear estrellas brillantes
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
    
$(document).ready(function () {
    $("#btn_login").on("click", function () {
        const usuario = $("#usuario").val().trim();
        const password = $("#password").val().trim();

        if (usuario === "" || password === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Campos vacíos',
                text: 'Por favor completa todos los campos.',
                confirmButtonColor: '#0d6efd'
            });
            return;
        }

        $.ajax({
            url: "_actions/login.php",
            method: "POST",
            data: { usuario: usuario, password: password },
            dataType: "json",
            success: function (response) {
                if (response.success === 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bienvenido',
                        text: 'Inicio de sesión exitoso.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "./";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Acceso denegado',
                        text: 'Usuario o contraseña incorrectos.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error del servidor',
                    text: 'No se pudo procesar la solicitud.',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    });
});
</script>

</body>

</html>
