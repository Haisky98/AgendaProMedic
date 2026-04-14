<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>AgendaPro Medic | Gestión Inteligente de Citas Médicas</title>
    <!-- Google Fonts + Inter + Plus Jakarta -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Swiper JS (modern carousel para testimonios) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background: #ffffff;
            overflow-x: hidden;
            color: #1a3b44;
            scroll-behavior: smooth;
        }

        /* ===== FONDO ORGÁNICO + GLASS MORPHISM (NUEVA PALETA) ===== */
        .bg-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .float-element {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.3;
        }

        .elem-1 {
            top: -15%;
            right: -5%;
            width: 750px;
            height: 750px;
            background: radial-gradient(circle, #e1f0f5, #cae2ec);
            animation: driftSlow 32s ease-in-out infinite;
        }

        .logo-img{
            width: 150px;
            height: 60px;
        }
        .elem-2 {
            bottom: -15%;
            left: -10%;
            width: 850px;
            height: 850px;
            background: radial-gradient(circle, #dbeaf0, #eef3f7);
            animation: driftSlow 36s ease-in-out infinite reverse;
        }

        .elem-3 {
            top: 40%;
            left: 30%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, #f2f7fa, #ffffff);
            animation: softPulse 18s ease-in-out infinite;
        }

        @keyframes driftSlow {
            0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
            50% { transform: translate(-40px, -30px) rotate(3deg) scale(1.08); }
        }

        @keyframes softPulse {
            0%, 100% { transform: scale(1); opacity: 0.2; }
            50% { transform: scale(1.2); opacity: 0.35; }
        }

        /* ===== NAVBAR MODERNO CON COLORES ACTUALIZADOS ===== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1100;
            padding: 1rem 2rem;
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(18px);
            transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            border-bottom: 1px solid rgba(95, 145, 165, 0.3);
        }

        .navbar.scrolled {
            padding: 0.7rem 2rem;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.03);
            border-bottom-color: rgba(42, 73, 85, 0.25);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(145deg, #e2f0f5, #cde2ec);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 22px -8px rgba(42, 73, 85, 0.2);
            transition: all 0.25s ease;
        }

        .logo-icon i {
            font-size: 1.7rem;
            color: #2a4955;
        }

        .logo-text h1 {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(125deg, #2a4955, #5f91a5);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            letter-spacing: -0.3px;
        }

        .logo-text p {
            font-size: 0.65rem;
            color: #99bbc9;
            font-weight: 500;
        }

        /* Botones navegación mejorados */
        .nav-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-nav-agendar {
            background: rgba(95, 145, 165, 0.12);
            backdrop-filter: blur(4px);
            padding: 0.7rem 1.8rem;
            border-radius: 60px;
            text-decoration: none;
            color: #2a4955;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(95, 145, 165, 0.5);
        }

        .btn-nav-agendar:hover {
            background: #eef4f8;
            transform: translateY(-2px);
            border-color: #5f91a5;
            box-shadow: 0 6px 14px rgba(42, 73, 85, 0.1);
        }

        .btn-login-nav {
            background: #5f91a5;
            padding: 0.7rem 2rem;
            border-radius: 60px;
            text-decoration: none;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 5px 14px rgba(95, 145, 165, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-login-nav:hover {
            transform: translateY(-3px);
            background: #477b8f;
            box-shadow: 0 12px 24px rgba(42, 73, 85, 0.25);
        }

        /* ===== HERO MODERNO CON NUEVA PALETA ===== */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 8rem 2rem 5rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-left h1 {
            font-size: 3.8rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
            background: linear-gradient(125deg, #2a4955 20%, #5f91a5 70%, #87b5c7 95%);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(95, 145, 165, 0.12);
            backdrop-filter: blur(8px);
            padding: 0.5rem 1.3rem;
            border-radius: 80px;
            margin-bottom: 1.8rem;
            font-weight: 600;
            font-size: 0.8rem;
            color: #2a4955;
            border: 1px solid rgba(95, 145, 165, 0.35);
        }

        .hero-description {
            font-size: 1.15rem;
            color: #5c7f8c;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(105deg, #5f91a5, #2a4955);
            padding: 1rem 2.5rem;
            border-radius: 80px;
            text-decoration: none;
            color: white;
            font-weight: 800;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 14px 28px -8px rgba(42, 73, 85, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 35px -12px rgba(42, 73, 85, 0.5);
            background: linear-gradient(105deg, #74a2b5, #2f5d6e);
        }

        .btn-secondary {
            background: rgba(255, 255, 245, 0.85);
            backdrop-filter: blur(10px);
            padding: 1rem 2.2rem;
            border-radius: 80px;
            text-decoration: none;
            color: #2a4955;
            font-weight: 700;
            border: 1px solid #cde2ec;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-secondary:hover {
            background: #ffffff;
            border-color: #5f91a5;
            transform: translateY(-3px);
            color: #2a4955;
        }

        .btn-outline-explore {
            background: transparent;
            backdrop-filter: blur(8px);
            padding: 1rem 2rem;
            border-radius: 80px;
            text-decoration: none;
            color: #5f91a5;
            font-weight: 600;
            border: 1px solid #cbdbe2;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-outline-explore:hover {
            border-color: #5f91a5;
            background: rgba(95, 145, 165, 0.05);
            transform: translateY(-2px);
            color: #2a4955;
        }

        .hero-right {
            position: relative;
        }

        .hero-image-wrapper {
            border-radius: 48px;
            overflow: hidden;
            box-shadow: 0 40px 60px -20px rgba(0, 0, 0, 0.12);
            transform: rotate(1deg);
            transition: all 0.4s;
        }

        .hero-image-wrapper:hover {
            transform: rotate(0deg) scale(1.01);
        }

        .hero-image {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.6s ease;
        }

        .floating-card {
            position: absolute;
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(16px);
            border-radius: 32px;
            padding: 1rem 1.8rem;
            box-shadow: 0 25px 45px -12px rgba(0, 0, 0, 0.12);
            display: flex;
            align-items: center;
            gap: 14px;
            border: 1px solid rgba(95, 145, 165, 0.4);
            animation: floatModern 5s ease-in-out infinite;
        }

        .card-1 { top: -20px; right: -20px; animation-delay: 0s; }
        .card-2 { bottom: 30px; left: -25px; animation-delay: 1.2s; }

        @keyframes floatModern {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-14px); }
        }

        /* ===== FEATURES GLASS CARD (NUEVOS ACENTOS) ===== */
        .features {
            padding: 6rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header h2 {
            font-size: 2.7rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            background: linear-gradient(125deg, #2a4955, #5f91a5);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            padding: 2rem 1.8rem;
            border-radius: 44px;
            transition: all 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            border: 1px solid rgba(95, 145, 165, 0.25);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.95);
            border-color: #5f91a5;
            box-shadow: 0 28px 40px -18px rgba(42, 73, 85, 0.2);
        }

        .feature-icon {
            width: 74px;
            height: 74px;
            background: linear-gradient(135deg, #eef4f8, #e2edf3);
            border-radius: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.6rem;
        }

        .feature-icon i {
            font-size: 2.2rem;
            color: #5f91a5;
        }

        /* ===== STATS (NUEVA PALETA) ===== */
        .stats {
            background: rgba(248, 253, 250, 0.7);
            backdrop-filter: blur(8px);
            border-radius: 80px;
            padding: 4rem 2rem;
            max-width: 1200px;
            margin: 2rem auto;
            border: 1px solid rgba(95, 145, 165, 0.35);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #2a4955, #5f91a5);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        /* ===== HOW IT WORKS ===== */
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3rem;
        }

        .step {
            text-align: center;
            background: rgba(255, 255, 245, 0.5);
            padding: 2rem 1rem;
            border-radius: 48px;
            backdrop-filter: blur(4px);
            transition: all 0.3s;
        }

        .step-number {
            width: 78px;
            height: 78px;
            background: linear-gradient(145deg, #cde2ec, #bfd8e4);
            border-radius: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 800;
            color: #2a4955;
            margin: 0 auto 1.5rem;
            box-shadow: 0 12px 20px -8px rgba(42, 73, 85, 0.2);
        }

        /* ===== SWIPER TESTIMONIOS ===== */
        .testimonials {
            padding: 4rem 2rem;
            max-width: 1300px;
            margin: 0 auto;
        }

        .swiper {
            width: 100%;
            padding: 1rem 0 3rem;
        }

        .testimonial-slide {
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(12px);
            border-radius: 48px;
            padding: 2rem;
            border: 1px solid rgba(95, 145, 165, 0.4);
            transition: all 0.3s;
        }

        .testimonial-text {
            font-size: 1rem;
            line-height: 1.6;
            color: #406b7c;
            margin-bottom: 1.5rem;
        }

        .author-avatar {
            width: 52px;
            height: 52px;
            background: #e2f0f5;
            border-radius: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #5f91a5;
        }

        .swiper-pagination-bullet-active {
            background: #5f91a5 !important;
        }

        /* ===== CTA (NUEVA PALETA) ===== */
        .cta {
            background: linear-gradient(125deg, rgba(227, 240, 245, 0.9), rgba(248, 246, 242, 0.9));
            backdrop-filter: blur(8px);
            border-radius: 70px;
            padding: 5rem 2rem;
            text-align: center;
            border: 1px solid rgba(95, 145, 165, 0.4);
        }

        .cta .btn-primary {
            background: linear-gradient(115deg, #2a4955, #5f91a5);
            color: white;
            box-shadow: 0 15px 30px -10px rgba(42, 73, 85, 0.4);
        }

        /* ===== FOOTER DARK CON TONOS #2a4955 ===== */
        .footer {
            background: #1a3f4b;
            color: #eaf4f9;
            padding: 4rem 2rem 2rem;
            margin-top: 4rem;
        }

        .footer-section h4 {
            color: #cde2ec;
            margin-bottom: 1rem;
        }

        .footer-section a {
            color: #b8d2e0;
            text-decoration: none;
            transition: 0.2s;
        }

        .footer-section a:hover {
            color: white;
        }

        .social-links a {
            background: rgba(255, 255, 255, 0.1);
            display: inline-flex;
            margin-right: 0.8rem;
            padding: 0.5rem;
            border-radius: 40px;
            width: 38px;
            justify-content: center;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .hero-grid { grid-template-columns: 1fr; text-align: center; gap: 2rem; }
            .hero-buttons { justify-content: center; }
            .stats-grid { grid-template-columns: repeat(2,1fr); }
            .steps-grid { grid-template-columns: 1fr; gap: 2rem; }
            .hero-left h1 { font-size: 2.6rem; }
            .features-grid { grid-template-columns: 1fr; }
            .nav-buttons { gap: 0.7rem; }
            .btn-nav-agendar, .btn-login-nav { padding: 0.5rem 1.2rem; font-size: 0.8rem; }
        }
        @media (max-width: 580px) {
            .stats-grid { grid-template-columns: 1fr; }
            .navbar { padding: 0.7rem 1rem; }
            .hero { padding: 6rem 1rem 3rem; }
            .nav-buttons { gap: 0.5rem; }
        }

        [data-aos] {
            animation-fill-mode: both;
        }
    </style>
</head>
<body>

<div class="bg-elements">
    <div class="float-element elem-1"></div>
    <div class="float-element elem-2"></div>
    <div class="float-element elem-3"></div>
</div>

<nav class="navbar" id="navbar">
    <div class="nav-container">
        <a href="#" class="logo">
            <img src="assets/images/logo-png.png" alt="" class="logo-img">
            <!-- <div class="logo-icon"><i class="fas fa-calendar-check"></i></div>
            <div class="logo-text"><h1>AgendaPro Medic</h1><p>Gestión inteligente</p></div> -->
        </a>
        <div class="nav-buttons">
            <a href="agenda/" class="btn-nav-agendar"><i class="fas fa-calendar-plus"></i> Agendar Cita</a>
            <a href="login.php" class="btn-login-nav"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a>
        </div>
    </div>
</nav>

<main class="main-content">
    <section class="hero">
        <div class="hero-grid">
            <div class="hero-left" data-aos="fade-up" data-aos-duration="900">
                <div class="hero-badge"><i class="fas fa-sparkles"></i><span>+12,500 citas gestionadas este mes</span></div>
                <h1>Gestiona citas médicas con <span style="color:#5f91a5;">elegancia</span> y <span style="color:#2a4955;">precisión</span></h1>
                <p class="hero-description">AgendaPro Medic revoluciona tu práctica: agendamiento sin fricción, recordatorios automáticos y analítica clara. Más tiempo para cuidar, cero estrés administrativo.</p>
                <div class="hero-buttons">
                    <a href="agenda/" class="btn-primary"><i class="fas fa-calendar-plus"></i> Agendar cita ahora</a>
                    <a href="login.php" class="btn-secondary"><i class="fas fa-user-md"></i> Iniciar sesión</a>
                    <a href="#features" class="btn-outline-explore"><i class="fas fa-play-circle"></i> Explorar</a>
                </div>
            </div>
            <div class="hero-right" data-aos="fade-up" data-aos-delay="250">
                <div class="hero-image-wrapper">
                    <img class="hero-image" src="https://images.unsplash.com/photo-1584515933487-779824d29309?w=700&h=550&fit=crop" alt="Especialista con tableta">
                </div>
                <div class="floating-card card-1"><i class="fas fa-clock" style="font-size:1.8rem; color:#5f91a5;"></i><div><strong style="color:#2a4955;">-75% inasistencias</strong><p style="font-size:0.7rem;">recordatorios smart</p></div></div>
                <div class="floating-card card-2"><i class="fas fa-chart-simple" style="font-size:1.8rem; color:#5f91a5;"></i><div><strong style="color:#2a4955;">+40% eficiencia</strong><p style="font-size:0.7rem;">en tu agenda</p></div></div>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="section-header" data-aos="fade-up"><h2>Herramientas pensadas para el profesional moderno</h2><p style="color:#7b9eac;">Tecnología fluida, resultados tangibles</p></div>
        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100"><div class="feature-icon"><i class="fas fa-calendar-check"></i></div><h3>Booking inteligente</h3><p>Asigna horarios sin superposiciones, con sincronización en tiempo real y vista semanal optimizada.</p></div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200"><div class="feature-icon"><i class="fas fa-bell"></i></div><h3>Recordatorios omnicanal</h3><p>WhatsApp, SMS y email automáticos reducen ausencias y mejoran la experiencia del paciente.</p></div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300"><div class="feature-icon"><i class="fas fa-folder-medical"></i></div><h3>Expediente digital 360</h3><p>Historiales unificados, notas clínicas y recetas electrónicas seguras al alcance de un click.</p></div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="400"><div class="feature-icon"><i class="fas fa-chart-line"></i></div><h3>Analytics & KPIs</h3><p>Dashboard con métricas de ocupación, retención y tendencias para decisiones basadas en datos.</p></div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="500"><div class="feature-icon"><i class="fas fa-shield-heart"></i></div><h3>Privacidad absoluta</h3><p>Cumplimiento RGPD/LOPD, datos cifrados y accesos por roles. Tu información segura.</p></div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="600"><div class="feature-icon"><i class="fas fa-mobile-screen"></i></div><h3>Mobile-first experience</h3><p>UI adaptable, perfecta desde tu smartphone o tablet. Gestiona tu consulta desde cualquier lugar.</p></div>
        </div>
    </section>

    <section class="stats" data-aos="zoom-in">
        <div class="stats-grid">
            <div class="stat-item"><h3>12k+</h3><p>Citas gestionadas</p></div>
            <div class="stat-item"><h3>650+</h3><p>Especialistas activos</p></div>
            <div class="stat-item"><h3>99%</h3><p>Recomiendan</p></div>
            <div class="stat-item"><h3>24/7</h3><p>Soporte humano + IA</p></div>
        </div>
    </section>

    <section class="how-it-works" style="padding: 5rem 2rem; max-width:1300px; margin:0 auto;">
        <div class="section-header" data-aos="fade-up"><h2>Tu viaje hacia la gestión perfecta</h2><p>Configuración rápida, resultados inmediatos</p></div>
        <div class="steps-grid">
            <div class="step" data-aos="fade-up" data-aos-delay="100"><div class="step-number">1</div><h3>Registro express</h3><p>Completa tus datos en menos de 90 segundos y accede al dashboard inteligente.</p></div>
            <div class="step" data-aos="fade-up" data-aos-delay="200"><div class="step-number">2</div><h3>Personaliza tu agenda</h3><p>Bloques horarios, descansos, servicios y precios con diseño arrastrable.</p></div>
            <div class="step" data-aos="fade-up" data-aos-delay="300"><div class="step-number">3</div><h3>Conecta con pacientes</h3><p>Comparte enlace de reserva, recibe notificaciones y optimiza tu flujo de trabajo.</p></div>
        </div>
    </section>

    <section class="testimonials">
        <div class="section-header" data-aos="fade-up"><h2>Confianza de profesionales de la salud</h2><p>Más de 500 clínicas ya transformaron su día a día</p></div>
        <div class="swiper testimonial-swiper" data-aos="fade-up">
            <div class="swiper-wrapper">
                <div class="swiper-slide testimonial-slide"><p class="testimonial-text">“La mejor inversión para mi consulta. Los recordatorios por WhatsApp redujeron un 80% las ausencias y ahora tengo control total desde mi móvil.”</p><div class="testimonial-author"><div class="author-avatar"><i class="fas fa-user-md"></i></div><div><h4>Dra. Camila Herrera</h4><p>Medicina Interna</p></div></div></div>
                <div class="swiper-slide testimonial-slide"><p class="testimonial-text">“Increíble diseño y UX. La integración con mi agenda ha sido impecable. Mis pacientes agradecen la facilidad para reservar y reagendar.”</p><div class="testimonial-author"><div class="author-avatar"><i class="fas fa-user-md"></i></div><div><h4>Dr. Sebastián Moya</h4><p>Cardiólogo intervencionista</p></div></div></div>
                <div class="swiper-slide testimonial-slide"><p class="testimonial-text">“Reportes avanzados que me permiten visualizar la ocupación y crecimiento. Soporte excepcional. AgendaPro Medic es el futuro de la gestión clínica.”</p><div class="testimonial-author"><div class="author-avatar"><i class="fas fa-user-md"></i></div><div><h4>Dra. Valeria Ríos</h4><p>Directora Clínica R&R</p></div></div></div>
                <div class="swiper-slide testimonial-slide"><p class="testimonial-text">“Me encanta la interfaz limpia y moderna. Pasé de usar hojas de cálculo a un sistema automatizado que me libera horas administrativas.”</p><div class="testimonial-author"><div class="author-avatar"><i class="fas fa-user-md"></i></div><div><h4>Dr. Andrés Peñalosa</h4><p>Dermatología estética</p></div></div></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <section class="cta" data-aos="zoom-in" style="max-width:1200px; margin:3rem auto;">
        <h2 style="font-size:2rem;">La nueva era de la gestión médica te espera</h2>
        <p style="margin-bottom:2rem;">Únete a la comunidad que ya optimiza su tiempo y mejora la experiencia del paciente.</p>
        <!-- <a href="#agendar" class="btn-primary" style="background: linear-gradient(115deg, #2a4955, #5f91a5); color:white;"><i class="fas fa-arrow-right"></i> Empieza gratis — sin tarjeta</a> -->
    </section>
</main>

<footer class="footer">
    <div class="footer-content" style="max-width:1300px; margin:0 auto; display:grid; grid-template-columns:2fr 1fr 1fr 1.5fr; gap:3rem;">
        <div class="footer-section"><h4>AgendaPro Medic</h4><p>Plataforma integral que fusiona diseño y tecnología para una gestión de citas médicas sin fricciones.</p><div class="social-links"><a href="#"><i class="fab fa-linkedin-in"></i></a><a href="#"><i class="fab fa-instagram"></i></a><a href="#"><i class="fab fa-x-twitter"></i></a></div></div>
        <div class="footer-section"><h4>Explora</h4><p><a href="#features">Funcionalidades</a></p><p><a href="#">Planes</a></p><p><a href="#">Testimonios reales</a></p><p><a href="#">Centro de ayuda</a></p></div>
        <div class="footer-section"><h4>Compañía</h4><p><a href="#">Nosotros</a></p><p><a href="#">Blog Innovación</a></p><p><a href="#">Prensa</a></p><p><a href="#">Carreras</a></p></div>
        <div class="footer-section"><h4>Legal & privacidad</h4><p><a href="#">Términos de uso</a></p><p><a href="#">Política de privacidad</a></p><p><a href="#">Protección de datos</a></p><p><a href="#">Cookies</a></p></div>
    </div>
    <div class="footer-bottom" style="text-align:center; padding-top:2rem; margin-top:2rem; border-top:1px solid rgba(255,255,255,0.1);"><p>© 2025 AgendaPro Medic — Cuidado de salud con inteligencia y calidez. Todos los derechos reservados.</p></div>
</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    AOS.init({ once: true, offset: 50, duration: 700 });
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 40) navbar.classList.add('scrolled');
        else navbar.classList.remove('scrolled');
    });
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#' || targetId === '#agendar' || targetId === '#login') {
                e.preventDefault();
                // demo smooth placeholder - sin funcionalidad rota
                if(targetId === '#agendar') alert('🔔 Demo: Flujo de agendamiento disponible en versión completa.');
                if(targetId === '#login') alert('🔐 Demo: Acceso a plataforma en construcción — pronto disponible.');
                return;
            }
            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
    const swiper = new Swiper('.testimonial-swiper', {
        loop: true,
        autoplay: { delay: 3800, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
        slidesPerView: 1,
        spaceBetween: 24,
        breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
    });
</script>
</body>
</html>