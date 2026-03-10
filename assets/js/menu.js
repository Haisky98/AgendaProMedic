//******** MENÚ ********//
$(document).ready(function () {
  const vistas = {
    dashboard_principal: '_system/dashboard.php',
    cat_estatus_citas: '_system/cat_estatus_citas.php',
    cat_especialidades: '_system/cat_especialidades.php',
    cat_servicios: '_system/cat_servicios.php',
    cat_horarios: '_system/cat_hora_cita.php',
    cat_consultorios: '_system/cat_consultorios.php',
    cat_medicos: '_system/cat_medicos.php',
    report_citas: '_system/report_citas.php',
    report_productividad: '_system/report_productividad.php'
  };

  function cargarVista(urlVista) {
    $("#principal").fadeIn(250).load(urlVista, function (response, status, xhr) {
      if (status === 'error') {
        if (xhr && xhr.status === 401) {
          window.location.href = './login.php';
          return;
        }
        alert('No se pudo cargar la vista solicitada.');
      }
    });
  }

  Object.keys(vistas).forEach(function (id) {
    $(document).on('click', '#' + id, function (e) {
      e.preventDefault();
      cargarVista(vistas[id]);
    });
  });

  /*---------------- CERRAR SESIÓN ----------------*/
  $(document).on('click', '#cerrar_sesion', function () {
    $.ajax({
      url: '_actions/cerrar_sesion.php',
      type: 'POST',
      dataType: 'json'
    })
      .always(function () {
        window.location.href = './login.php';
      });
  });

  $(document).ajaxError(function (event, xhr) {
    if (xhr && xhr.status === 401) {
      window.location.href = './login.php';
    }
  });
});
