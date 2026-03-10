<?php require_once __DIR__ . '/auth_guard.php'; ?>
<div class="pcoded-inner-content">
  <div class="main-body">
    <div class="page-wrapper">
      <div class="page-header card">
        <div class="row align-items-end">
          <div class="col-lg-8">
            <div class="page-header-title">
              <i class="icofont icofont-dashboard bg-c-blue"></i>
              <div class="d-inline">
                <h4>Panel de Inicio</h4>
                <span>Resumen operativo del día</span>
              </div>
            </div>
          </div>
          <div class="col-lg-4 text-right">
            <span class="text-muted">Actualizado en tiempo real</span>
          </div>
        </div>
      </div>

      <div class="page-body">
        <div class="row">
          <div class="col-md-6 col-xl-4">
            <div class="card widget-card-1">
              <div class="card-block-small">
                <i class="icofont icofont-calendar bg-c-blue card1-icon"></i>
                <span class="text-c-blue f-w-600">Citas de hoy</span>
                <h4 id="metric_citas_hoy">0</h4>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-xl-4">
            <div class="card widget-card-1">
              <div class="card-block-small">
                <i class="icofont icofont-money-bag bg-c-green card1-icon"></i>
                <span class="text-c-green f-w-600">Ingresos del día</span>
                <h4 id="metric_ingresos_hoy">$0.00</h4>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-xl-4">
            <div class="card widget-card-1">
              <div class="card-block-small">
                <i class="icofont icofont-ui-timer bg-c-yellow card1-icon"></i>
                <span class="text-c-yellow f-w-600">Pendientes de confirmación</span>
                <h4 id="metric_pendientes">0</h4>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5>Productividad por médico (hoy)</h5>
              </div>
              <div class="card-block">
                <div id="top_medicos_grafica">
                  <p class="text-muted mb-0">Sin datos para mostrar.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function formatoMoneda(value) {
    const numero = Number(value || 0);
    return `$${numero.toFixed(2)}`;
  }

  function renderTopMedicos(lista) {
    const contenedor = $('#top_medicos_grafica');
    if (!Array.isArray(lista) || lista.length === 0) {
      contenedor.html('<p class="text-muted mb-0">No hay citas registradas para hoy.</p>');
      return;
    }

    const maximo = Math.max(...lista.map(item => Number(item.total_citas || 0)), 1);
    let html = '';
    lista.forEach(item => {
      const total = Number(item.total_citas || 0);
      const porcentaje = Math.max(5, Math.round((total / maximo) * 100));
      html += `
        <div class="m-b-20">
          <div class="d-flex justify-content-between">
            <span class="f-w-600">${item.medico}</span>
            <span class="text-muted">${total} citas</span>
          </div>
          <div class="progress" style="height: 10px;">
            <div class="progress-bar bg-c-blue" role="progressbar" style="width: ${porcentaje}%"></div>
          </div>
        </div>
      `;
    });
    contenedor.html(html);
  }

  function cargarDashboard() {
    $.ajax({
      url: '_actions/dashboard_resumen.php',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (!response || !response.success) {
          return;
        }

        $('#metric_citas_hoy').text(response.resumen.total_citas_hoy || 0);
        $('#metric_ingresos_hoy').text(formatoMoneda(response.resumen.ingresos_hoy));
        $('#metric_pendientes').text(response.resumen.pendientes_confirmacion || 0);
        renderTopMedicos(response.top_medicos || []);
      }
    });
  }

  function iniciarDashboard() {
    if (!window.jQuery) {
      return false;
    }

    cargarDashboard();
    return true;
  }

  (function bootstrapDashboard() {
    // Caso AJAX: jQuery ya existe al momento de inyectar esta vista.
    if (iniciarDashboard()) {
      return;
    }

    // Caso carga inicial: esperar DOM y, si hace falta, evento load.
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', function () {
        if (!iniciarDashboard()) {
          window.addEventListener('load', iniciarDashboard, { once: true });
        }
      }, { once: true });
      return;
    }

    window.addEventListener('load', iniciarDashboard, { once: true });
  })();
</script>
