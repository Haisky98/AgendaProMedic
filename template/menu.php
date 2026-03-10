<?php
$rolActual = strtolower(trim($_SESSION['rol'] ?? ''));
$esAdmin = ($rolActual === 'admin');
$esMedico = ($rolActual === 'medico');
?>
<nav class="pcoded-navbar">
  <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
  <div class="pcoded-inner-navbar main-menu">
    <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">Menu</div>
    <ul class="pcoded-item pcoded-left-item">

      <?php if ($esAdmin): ?>
      <li>
        <a href="#" id="dashboard_principal" onclick="return agpOpenView('_system/dashboard.php', event);">
          <span class="pcoded-micon"><i class="ti-dashboard"></i></span>
          <span class="pcoded-mtext">Inicio</span>
          <span class="pcoded-mcaret"></span>
        </a>
      </li>

      <li class="pcoded-hasmenu">
        <a href="#" onclick="return agpToggleMenu(this, event);">
          <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
          <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Catalogos</span>
          <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
          <li>
            <a href="#" id="cat_estatus_citas" onclick="return agpOpenView('_system/cat_estatus_citas.php', event);">
              <span class="pcoded-micon"><i class="ti-layout-list-thumb-alt"></i></span>
              <span class="pcoded-mtext">Estatus Citas</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li>
            <a href="#" id="cat_especialidades" onclick="return agpOpenView('_system/cat_especialidades.php', event);">
              <span class="pcoded-micon"><i class="ti-medall"></i></span>
              <span class="pcoded-mtext">Especialidades</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li>
            <a href="#" id="cat_servicios" onclick="return agpOpenView('_system/cat_servicios.php', event);">
              <span class="pcoded-micon"><i class="ti-clipboard"></i></span>
              <span class="pcoded-mtext">Servicios</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li>
            <a href="#" id="cat_horarios" onclick="return agpOpenView('_system/cat_hora_cita.php', event);">
              <span class="pcoded-micon"><i class="ti-time"></i></span>
              <span class="pcoded-mtext">Horarios Citas</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li>
            <a href="#" id="cat_consultorios" onclick="return agpOpenView('_system/cat_consultorios.php', event);">
              <span class="pcoded-micon"><i class="ti-home"></i></span>
              <span class="pcoded-mtext">Consultorios</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li>
            <a href="#" id="cat_medicos" onclick="return agpOpenView('_system/cat_medicos.php', event);">
              <span class="pcoded-micon"><i class="ti-user"></i></span>
              <span class="pcoded-mtext">Medicos</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
          <li>
            <a href="#" id="cat_usuarios" onclick="return agpOpenView('_system/cat_usuarios.php', event);">
              <span class="pcoded-micon"><i class="ti-id-badge"></i></span>
              <span class="pcoded-mtext">Usuarios</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
        </ul>
      </li>

      <li class="pcoded-hasmenu">
        <a href="#" onclick="return agpToggleMenu(this, event);">
          <span class="pcoded-micon"><i class="ti-calendar"></i></span>
          <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Agenda</span>
          <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
          <li>
            <a href="#" id="report_citas" onclick="return agpOpenView('_system/report_citas.php', event);">
              <span class="pcoded-micon"><i class="ti-layout-list-thumb-alt"></i></span>
              <span class="pcoded-mtext">Recepcion de Citas</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
        </ul>
      </li>

      <li class="pcoded-hasmenu">
        <a href="#" onclick="return agpToggleMenu(this, event);">
          <span class="pcoded-micon"><i class="ti-bar-chart"></i></span>
          <span class="pcoded-mtext">Gerencia</span>
          <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
          <li>
            <a href="#" id="report_productividad" onclick="return agpOpenView('_system/report_productividad.php', event);">
              <span class="pcoded-micon"><i class="ti-stats-up"></i></span>
              <span class="pcoded-mtext">Reporte Financiero</span>
              <span class="pcoded-mcaret"></span>
            </a>
          </li>
        </ul>
      </li>
      <?php endif; ?>

      <?php if ($esMedico): ?>
      <li>
        <a href="#" id="mis_citas" onclick="return agpOpenView('_system/report_citas.php', event);">
          <span class="pcoded-micon"><i class="ti-calendar"></i></span>
          <span class="pcoded-mtext">Mis Citas</span>
          <span class="pcoded-mcaret"></span>
        </a>
      </li>
      <?php endif; ?>

    </ul>
  </div>
</nav>

<script>
  function agpToggleMenu(anchor, event) {
    if (event) {
      event.preventDefault();
      event.stopPropagation();
    }

    var parent = anchor;
    while (parent && (!parent.classList || !parent.classList.contains('pcoded-hasmenu'))) {
      parent = parent.parentElement;
    }

    if (!parent) {
      return false;
    }

    var isOpen = parent.classList.contains('pcoded-trigger');
    document.querySelectorAll('.pcoded-hasmenu.pcoded-trigger').forEach(function (li) {
      if (li !== parent) {
        li.classList.remove('pcoded-trigger');
      }
    });

    parent.classList.toggle('pcoded-trigger', !isOpen);
    return false;
  }

  function agpOpenView(urlVista, event) {
    if (event) {
      event.preventDefault();
      event.stopPropagation();
    }

    if (!window.jQuery) {
      window.location.href = urlVista;
      return false;
    }

    var $principal = window.jQuery('#principal');
    if (!$principal.length) {
      window.location.href = urlVista;
      return false;
    }

    $principal.fadeIn(250).load(urlVista, function (response, status, xhr) {
      if (status === 'error') {
        if (xhr && xhr.status === 401) {
          window.location.href = './login.php';
          return;
        }
        alert('No se pudo cargar la vista solicitada.');
      }
    });

    return false;
  }
</script>
