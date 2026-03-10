<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/_class/session_helper.php';
date_default_timezone_set('America/Mexico_City');
agp_require_auth_page('login.php');
?>
<!DOCTYPE html>
<html lang="en">
<?php  
    include('template/head.php');
?>
  <body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">

                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
        <?php  
            include('template/header.php');
        ?>
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <?php  
                        include('template/menu.php');
                    ?>
                    <div class="pcoded-content" id="principal">
                    <?php  
                        include('principal.php');
                    ?>
                    </div>
                </div>
            </div>
        </div>

</body>
<?php
    include("template/footer.php");
?>
</html>
