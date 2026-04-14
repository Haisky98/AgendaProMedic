<?php
require_once __DIR__ . '/_class/session_helper.php';
agp_require_auth_page('login.php');

$nombre_usuario = $_SESSION['nombre'];
include_once('template/head.php');
?>

<style>
  /* ========== ESTILOS MODERNOS (coherentes con el dashboard) ========== */
  body {
    background: #f5f7fb;
    font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    padding: 20px;
  }

  .password-container {
    width: 100%;
    max-width: 550px;
    margin: 0 auto;
    animation: fadeIn 0.3s ease-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px);}
    to { opacity: 1; transform: translateY(0);}
  }

  /* Tarjeta moderna */
  .modern-card {
    background: white;
    border-radius: 32px;
    box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.08), 0 2px 6px rgba(0, 0, 0, 0.02);
    padding: 2rem 2rem 2.5rem;
    transition: all 0.2s ease;
    border: 1px solid rgba(0, 0, 0, 0.03);
  }

  /* Botón de regresar (arriba a la izquierda dentro de la tarjeta) */
  .back-button {
    margin-bottom: 1.5rem;
  }
  .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: none;
    border: none;
    color: #5b6e8c;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 40px;
    background: #f8fafc;
  }
  .btn-back:hover {
    background: #f1f5f9;
    color: #2c7da0;
    transform: translateX(-3px);
  }
  .btn-back i {
    font-size: 1rem;
  }

  .card-title {
    text-align: center;
    margin-bottom: 2rem;
  }

  .card-title h2 {
    font-size: 1.8rem;
    font-weight: 700;
    background: linear-gradient(135deg, #1f5e7e, #2c7da0);
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    letter-spacing: -0.3px;
  }

  .card-title p {
    color: #5b6e8c;
    font-size: 0.9rem;
    margin-top: 8px;
  }

  /* Campos de formulario */
  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-label {
    font-weight: 600;
    font-size: 0.85rem;
    color: #1e2f44;
    margin-bottom: 0.5rem;
    display: block;
    letter-spacing: 0.3px;
  }

  .input-container input {
    width: 100%;
    padding: 0.85rem 1.2rem;
    font-size: 0.95rem;
    border: 1px solid #e2e8f0;
    border-radius: 60px;
    background-color: #fff;
    transition: all 0.2s ease;
    color: #0f2c3d;
  }

  .input-container input:focus {
    outline: none;
    border-color: #2c7da0;
    box-shadow: 0 0 0 3px rgba(44, 125, 160, 0.2);
  }

  /* Botón principal */
  .btn-modern {
    background: linear-gradient(135deg, #2c7da0, #1f5e7e);
    border: none;
    border-radius: 60px;
    padding: 0.85rem 2rem;
    font-weight: 600;
    font-size: 1rem;
    color: white;
    width: 100%;
    transition: transform 0.15s, box-shadow 0.15s;
    cursor: pointer;
  }

  .btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(44, 125, 160, 0.3);
    background: linear-gradient(135deg, #1f5e7e, #154c66);
  }

  .btn-modern:active {
    transform: translateY(0);
  }

  /* Ajustes responsive */
  @media (max-width: 640px) {
    .password-container {
      padding: 0;
    }
    .modern-card {
      padding: 1.5rem;
    }
    .card-title h2 {
      font-size: 1.5rem;
    }
    .input-container input {
      padding: 0.7rem 1rem;
    }
  }

  /* Mejora para el mensaje de toastr (coherente con el diseño) */
  .toast-success {
    background-color: #2c7da0 !important;
  }
  .toast-error {
    background-color: #d9534f !important;
  }
</style>

<!-- CONTENEDOR PRINCIPAL -->
<div class="password-container">
  <div class="modern-card">
    <!-- Botón de regresar -->
    <div class="back-button">
      <a href="Index.php" class="btn-back">
        <i class="icofont icofont-arrow-left"></i> Regresar al Inicio
      </a>
    </div>

    <div class="card-title">
      <h2><i class="icofont icofont-lock" style="font-size: 2rem; margin-right: 8px;"></i> Actualizar Contraseña</h2>
      <p>Por seguridad, recomendamos cambiar tu contraseña periódicamente</p>
    </div>

    <form method="post" id="form_actualizar_password">
      <div class="form-group">
        <label class="form-label">Contraseña Actual</label>
        <div class="input-container">
          <input type="password" name="actual" id="actual" class="form-control" placeholder="••••••••" required autocomplete="current-password">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Nueva Contraseña</label>
        <div class="input-container">
          <input type="password" name="nueva" id="nueva" class="form-control" placeholder="••••••••" required autocomplete="new-password">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Confirmar Nueva Contraseña</label>
        <div class="input-container">
          <input type="password" name="confirmar" id="confirmar" class="form-control" placeholder="••••••••" required autocomplete="new-password">
        </div>
      </div>

      <button type="submit" class="btn-modern">
        <i class="icofont icofont-save me-2"></i> Actualizar Contraseña
      </button>

      <div class="text-center mt-3" id="mensaje_resultado"></div>
    </form>
  </div>
</div>

<!-- Scripts (jQuery, toastr y lógica original) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- IcoFont (si no está incluido en el head) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/icofont@1.0.1/css/icofont.min.css">

<script>
  $(document).ready(function() {
    toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "timeOut": "4000",
      "showDuration": "300",
      "hideDuration": "1000"
    };

    $('#form_actualizar_password').submit(function(e) {
      e.preventDefault();

      const nueva = $('#nueva').val();
      const confirmar = $('#confirmar').val();
      if (nueva !== confirmar) {
        toastr.error('Las contraseñas nuevas no coinciden.');
        return;
      }

      $.ajax({
        url: '_actions/actualizar_contrasena.php',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
          if (response.status === '1') {
            toastr.success(response.mensaje);
            $('#form_actualizar_password')[0].reset();
            // window.close(); // Descomentar si se necesita
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
</html>