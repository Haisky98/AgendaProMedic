<nav class="navbar-modern">
  <div class="navbar-modern-wrapper">

    <!-- Logo y botón hamburguesa -->
    <div class="navbar-modern-left">
      <div class="mobile-menu" id="mobile-collapse">
        <i class="ti-menu"></i>
      </div>
      <div class="sidebar_toggle">
        <a href="javascript:void(0)"><i class="ti-menu"></i></a>
      </div>
      <a href="index.php" class="navbar-logo">
        <img src="assets/images/logo-png.png" alt="Logo">
      </a>
    </div>

    <!-- Acciones izquierda (fullscreen) -->
    <div class="navbar-modern-actions">
      <a href="#" onclick="javascript:toggleFullScreen()" class="action-btn">
        <i class="ti-fullscreen"></i>
      </a>
    </div>

    <!-- Acciones derecha (notificaciones y perfil) -->
    <div class="navbar-modern-right">
      <!-- Notificaciones -->
      <div class="dropdown-notification">
        <a href="#" class="notification-trigger">
          <i class="ti-bell"></i>
          <span class="badge"></span>
        </a>
        <ul class="show-notification">
          <li>
            <h6>Notificaciones</h6>
            <label class="label label-danger">3</label>
          </li>
          <li>
            <div class="media">
              <img class="d-flex align-self-center img-radius" src="assets/images/avatar-4.jpg" alt="avatar">
              <div class="media-body">
                <h5 class="notification-user">John Doe</h5>
                <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                <span class="notification-time">30 minutes ago</span>
              </div>
            </div>
          </li>
          <li>
            <div class="media">
              <img class="d-flex align-self-center img-radius" src="assets/images/avatar-3.jpg" alt="avatar">
              <div class="media-body">
                <h5 class="notification-user">Joseph William</h5>
                <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                <span class="notification-time">30 minutes ago</span>
              </div>
            </div>
          </li>
          <li>
            <div class="media">
              <img class="d-flex align-self-center img-radius" src="assets/images/avatar-4.jpg" alt="avatar">
              <div class="media-body">
                <h5 class="notification-user">Sara Soudein</h5>
                <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                <span class="notification-time">30 minutes ago</span>
              </div>
            </div>
          </li>
        </ul>
      </div>

      <!-- Perfil de usuario -->
      <div class="dropdown-profile">
        <a href="#" class="profile-trigger">
          <img src="assets/images/avatar-4.jpg" class="profile-avatar" alt="User">
          <span class="profile-name"><?php echo isset($_SESSION["nombre"]) ? htmlspecialchars($_SESSION["nombre"]) : 'Usuario'; ?></span>
          <i class="ti-angle-down"></i>
        </a>
        <ul class="show-notification profile-notification">
          <li><a href="perfil.php"  id="perfil"><i class="ti-user"></i> Perfil</a></li>
          <li><a href="javascript:;" id="cerrar_sesion"><i class="ti-layout-sidebar-left"></i> Cerrar sesión</a></li>
        </ul>
      </div>
    </div>

  </div>
</nav>

<!-- Estilos modernos para el navbar -->
<style>
  /* Reset básico para el nav */
  .navbar-modern {
    background: #ffffff;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border-radius: 0 0 20px 20px;
    padding: 0 24px;
    position: sticky;
    top: 0;
    z-index: 1000;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
  }

  .navbar-modern-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 70px;
    gap: 20px;
  }

  /* Sección izquierda */
  .navbar-modern-left {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .mobile-menu, .sidebar_toggle {
    cursor: pointer;
    font-size: 1.4rem;
    color: #2c3e50;
    transition: color 0.2s;
  }
  .mobile-menu:hover, .sidebar_toggle:hover {
    color: #2c7da0;
  }

  .navbar-logo img {
    height: 45px;
    width: auto;
    object-fit: contain;
  }

  /* Botones de acción */
  .navbar-modern-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
    margin-left: 20px;
  }

  .action-btn {
    color: #5b6e8c;
    font-size: 1.2rem;
    transition: all 0.2s;
  }
  .action-btn:hover {
    color: #2c7da0;
    transform: translateY(-2px);
  }

  /* Sección derecha */
  .navbar-modern-right {
    display: flex;
    align-items: center;
    gap: 24px;
  }

  /* Notificaciones y perfil - estilos comunes para los dropdowns */
  .dropdown-notification, .dropdown-profile {
    position: relative;
  }

  .notification-trigger, .profile-trigger {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    color: #2c3e50;
    text-decoration: none;
    transition: color 0.2s;
  }
  .notification-trigger:hover, .profile-trigger:hover {
    color: #2c7da0;
  }
  .notification-trigger i {
    font-size: 1.3rem;
  }
  .badge {
    position: absolute;
    top: -5px;
    right: -8px;
    background: #e74c3c;
    color: white;
    border-radius: 30px;
    padding: 2px 6px;
    font-size: 0.7rem;
    font-weight: 600;
  }
  .profile-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e2e8f0;
    transition: border-color 0.2s;
  }
  .profile-trigger:hover .profile-avatar {
    border-color: #2c7da0;
  }
  .profile-name {
    font-weight: 500;
    font-size: 0.9rem;
  }
  .ti-angle-down {
    font-size: 0.8rem;
    transition: transform 0.2s;
  }
  .profile-trigger:hover .ti-angle-down {
    transform: rotate(180deg);
  }

  /* Dropdowns (se conservan las clases originales para no romper JS) */
  .show-notification {
    position: absolute;
    top: 55px;
    right: 0;
    width: 320px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    list-style: none;
    padding: 0;
    margin: 0;
    opacity: 0;
    visibility: hidden;
    transition: all 0.2s;
    z-index: 1100;
    border: 1px solid rgba(0,0,0,0.05);
  }
  .dropdown-notification:hover .show-notification,
  .dropdown-profile:hover .show-notification {
    opacity: 1;
    visibility: visible;
    top: 60px;
  }
  .show-notification li {
    padding: 12px 16px;
    border-bottom: 1px solid #f0f2f5;
  }
  .show-notification li:first-child {
    border-radius: 20px 20px 0 0;
    background: #f8fafc;
    font-weight: 600;
  }
  .show-notification li:last-child {
    border-bottom: none;
    border-radius: 0 0 20px 20px;
  }
  .media {
    display: flex;
    gap: 12px;
    align-items: center;
  }
  .img-radius {
    width: 40px;
    height: 40px;
    border-radius: 50%;
  }
  .media-body h5 {
    margin: 0 0 4px;
    font-size: 0.9rem;
    font-weight: 600;
  }
  .notification-msg {
    font-size: 0.8rem;
    color: #5b6e8c;
    margin: 0;
  }
  .notification-time {
    font-size: 0.7rem;
    color: #94a3b8;
  }

  /* Ajustes responsive */
  @media (max-width: 768px) {
    .navbar-modern {
      padding: 0 16px;
    }
    .profile-name {
      display: none;
    }
    .navbar-modern-right {
      gap: 16px;
    }
    .show-notification {
      width: 280px;
      right: -20px;
    }
  }

  @media (max-width: 480px) {
    .navbar-modern-wrapper {
      gap: 10px;
    }
    .navbar-logo img {
      height: 35px;
    }
    .action-btn {
      font-size: 1rem;
    }
  }
</style>

<!-- Asegurar que los iconos Themify estén disponibles (si ya los tienes, omite) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/themify-icons@0.1.2/css/themify-icons.css">