<?php require_once __DIR__ . '/auth_guard.php'; ?>
    <style>
        /* Contenedor principal */
        .dashboard-container {
            padding: 24px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header / Page Header */
        .page-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            gap: 16px;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-title i {
            font-size: 2.2rem;
            background: linear-gradient(135deg, #2c7da0, #1f5e7e);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .header-title h4 {
            font-size: 1.6rem;
            font-weight: 600;
            letter-spacing: -0.3px;
            color: #0f2c3d;
        }

        .header-title span {
            font-size: 0.9rem;
            color: #5b6e8c;
            display: block;
            margin-top: 4px;
        }

        .update-badge {
            background: #eef2ff;
            padding: 6px 14px;
            border-radius: 40px;
            font-size: 0.8rem;
            color: #2c7da0;
            font-weight: 500;
            backdrop-filter: blur(2px);
        }

        /* GRID DE TARJETAS (reemplaza row/col) */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        /* Tarjetas métricas modernas */
        .metric-card {
            background: white;
            border-radius: 28px;
            padding: 20px 24px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02), 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.25s ease;
            border: 1px solid rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .metric-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.1);
            border-color: rgba(44, 125, 160, 0.2);
        }

        .card-info {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .card-label {
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #5b6e8c;
        }

        .card-value {
            font-size: 2.2rem;
            font-weight: 700;
            line-height: 1.2;
            color: #0f2c3d;
        }

        .card-icon {
            width: 56px;
            height: 56px;
            background: #f0f9ff;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #2c7da0;
            transition: all 0.2s;
        }

        /* Variantes de color para los íconos (coincide con las métricas) */
        .metric-card:nth-child(1) .card-icon { background: #e6f7ff; color: #1f7b9c; }
        .metric-card:nth-child(2) .card-icon { background: #e6f9ef; color: #2b8c5e; }
        .metric-card:nth-child(3) .card-icon { background: #fff6e5; color: #e6a017; }

        /* Sección de productividad */
        .doctors-section {
            background: white;
            border-radius: 28px;
            padding: 24px 28px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02), 0 2px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            flex-wrap: wrap;
            margin-bottom: 24px;
            border-bottom: 2px solid #eef2f8;
            padding-bottom: 14px;
        }

        .section-header h5 {
            font-size: 1.35rem;
            font-weight: 600;
            color: #0f2c3d;
            letter-spacing: -0.2px;
        }

        .section-header p {
            font-size: 0.8rem;
            color: #7e8aa2;
        }

        /* Contenedor de la lista de médicos (donde se inyecta el JS) */
        .doctors-list {
            margin-top: 8px;
        }

        /* Estilos para las barras de progreso (reemplazan las clases de Bootstrap) */
        .progress {
            background-color: #e9eef3;
            border-radius: 40px;
            height: 10px;
            overflow: hidden;
            margin-top: 8px;
        }

        .progress-bar {
            background: linear-gradient(90deg, #2c7da0, #419ebd);
            border-radius: 40px;
            height: 100%;
            width: 0%;
            transition: width 0.3s ease;
        }

        /* Estilo para cada ítem de médico */
        .doctor-item {
            margin-bottom: 24px;
        }

        .doctor-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 6px;
        }

        .doctor-name {
            font-weight: 600;
            font-size: 1rem;
            color: #1e2f44;
        }

        .doctor-stats {
            font-size: 0.85rem;
            color: #5b6e8c;
            background: #f4f7fc;
            padding: 2px 10px;
            border-radius: 30px;
        }

        /* Mensaje cuando no hay datos */
        .empty-message {
            background: #fafcff;
            text-align: center;
            padding: 40px 20px;
            border-radius: 24px;
            color: #7e8aa2;
            font-weight: 500;
            border: 1px dashed #cbd5e1;
        }

        /* Responsive */
        @media (max-width: 640px) {
            body {
                padding: 16px;
            }
            .metric-card {
                padding: 16px 20px;
            }
            .card-value {
                font-size: 1.8rem;
            }
            .card-icon {
                width: 48px;
                height: 48px;
                font-size: 1.6rem;
            }
            .doctors-section {
                padding: 18px;
            }
            .section-header h5 {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 480px) {
            .cards-grid {
                gap: 16px;
            }
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* Animación sutil de carga */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .dashboard-container {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
<div class="dashboard-container">
    <!-- Encabezado (equivalente al page-header original) -->
    <div class="page-header">
        <div class="header-title">
            <i class="icofont icofont-dashboard"></i>
            <div>
                <h4>Panel de Inicio</h4>
                <span>Resumen operativo del día</span>
            </div>
        </div>
        <div class="update-badge">
            <i class="icofont icofont-clock-time"></i> Actualizado en tiempo real
        </div>
    </div>

    <!-- Grid de tarjetas métricas (3) -->
    <div class="cards-grid">
        <!-- Citas de hoy -->
        <div class="metric-card">
            <div class="card-info">
                <div class="card-label">
                    <i class="icofont icofont-calendar" style="font-size: 0.9rem; margin-right: 4px;"></i> Citas de hoy
                </div>
                <div class="card-value" id="metric_citas_hoy">0</div>
            </div>
            <div class="card-icon">
                <i class="icofont icofont-calendar"></i>
            </div>
        </div>

        <!-- Ingresos del día -->
        <div class="metric-card">
            <div class="card-info">
                <div class="card-label">
                    <i class="icofont icofont-money-bag" style="font-size: 0.9rem; margin-right: 4px;"></i> Ingresos del día
                </div>
                <div class="card-value" id="metric_ingresos_hoy">$0.00</div>
            </div>
            <div class="card-icon">
                <i class="icofont icofont-money-bag"></i>
            </div>
        </div>

        <!-- Pendientes de confirmación -->
        <div class="metric-card">
            <div class="card-info">
                <div class="card-label">
                    <i class="icofont icofont-ui-timer" style="font-size: 0.9rem; margin-right: 4px;"></i> Pendientes
                </div>
                <div class="card-value" id="metric_pendientes">0</div>
            </div>
            <div class="card-icon">
                <i class="icofont icofont-ui-timer"></i>
            </div>
        </div>
    </div>

    <!-- Sección productividad por médico (hoy) -->
    <div class="doctors-section">
        <div class="section-header">
            <h5>📊 Productividad por médico (hoy)</h5>
            <p>Actividad diaria</p>
        </div>
        <div id="top_medicos_grafica" class="doctors-list">
            <!-- Aquí se inyectará dinámicamente la lista de médicos -->
            <div class="empty-message">
                <i class="icofont icofont-info-circle" style="font-size: 1.6rem; margin-bottom: 8px; display: block;"></i>
                Sin datos para mostrar.
            </div>
        </div>
    </div>
</div>

<script>
    // Función de formato de moneda (idéntica a la original)
    function formatoMoneda(value) {
        const numero = Number(value || 0);
        return `$${numero.toFixed(2)}`;
    }

    // Render de la lista de médicos con barras de progreso (sin Bootstrap, usa nuestras clases .progress y .progress-bar)
    function renderTopMedicos(lista) {
        const contenedor = $('#top_medicos_grafica');
        if (!Array.isArray(lista) || lista.length === 0) {
            contenedor.html('<div class="empty-message"><i class="icofont icofont-info-circle" style="font-size: 1.6rem; margin-bottom: 8px; display: block;"></i>No hay citas registradas para hoy.</div>');
            return;
        }

        const maximo = Math.max(...lista.map(item => Number(item.total_citas || 0)), 1);
        let html = '';
        lista.forEach(item => {
            const total = Number(item.total_citas || 0);
            const porcentaje = Math.max(5, Math.round((total / maximo) * 100));
            html += `
                <div class="doctor-item">
                    <div class="doctor-row">
                        <span class="doctor-name">${escapeHtml(item.medico)}</span>
                        <span class="doctor-stats">${total} cita${total !== 1 ? 's' : ''}</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar" role="progressbar" style="width: ${porcentaje}%;"></div>
                    </div>
                </div>
            `;
        });
        contenedor.html(html);
    }

    // Función auxiliar para prevenir XSS (sanitiza nombres de médicos)
    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    // Carga los datos desde el endpoint (misma URL y estructura)
    function cargarDashboard() {
        $.ajax({
            url: '_actions/dashboard_resumen.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (!response || !response.success) {
                    // Si la respuesta no es exitosa, no actualizamos (se mantienen los valores por defecto)
                    return;
                }

                $('#metric_citas_hoy').text(response.resumen.total_citas_hoy || 0);
                $('#metric_ingresos_hoy').text(formatoMoneda(response.resumen.ingresos_hoy));
                $('#metric_pendientes').text(response.resumen.pendientes_confirmacion || 0);
                renderTopMedicos(response.top_medicos || []);
            },
            error: function() {
                // Silencioso en caso de error de red, mantiene datos previos o ceros
                console.warn('Error al cargar dashboard');
            }
        });
    }

    // Inicia el dashboard llamando a cargarDashboard y asegura jQuery
    function iniciarDashboard() {
        if (!window.jQuery) {
            return false;
        }
        cargarDashboard();
        return true;
    }

    // Mecanismo de arranque robusto (mantiene la misma lógica original, pero sin dependencia de Bootstrap)
    (function bootstrapDashboard() {
        if (iniciarDashboard()) {
            return;
        }
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
