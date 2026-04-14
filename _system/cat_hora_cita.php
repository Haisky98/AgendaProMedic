<?php require_once __DIR__ . '/auth_guard.php'; ?>
<style>
    /* ===== ESTILOS MODERNOS (mismo diseño que el dashboard) ===== */
    .dashboard-container {
        padding: 24px;
        max-width: 1400px;
        margin: 0 auto;
        animation: fadeIn 0.3s ease-out;
    }

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
        margin: 0;
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

    /* Sección / tarjeta principal */
    .schedule-section {
        background: white;
        border-radius: 28px;
        padding: 24px 28px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02), 0 2px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
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
        margin: 0;
    }

    /* Botón Agregar (estilo moderno) */
    .btn-modern {
        background: linear-gradient(135deg, #2c7da0, #1f5e7e);
        border: none;
        color: white;
        border-radius: 40px;
        padding: 8px 20px;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #236b8a, #154f6b);
        color: white;
        box-shadow: 0 6px 12px rgba(44,125,160,0.2);
    }

    /* Tabla personalizada */
    .modern-table-wrapper {
        overflow-x: auto;
        border-radius: 20px;
    }

    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.9rem;
    }

    .table-modern thead th {
        background: #f8fafd;
        color: #1e2f44;
        font-weight: 600;
        padding: 14px 16px;
        border-bottom: 2px solid #e2e8f0;
        font-size: 0.85rem;
        letter-spacing: 0.3px;
    }

    .table-modern tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #edf2f7;
        color: #2d3a4b;
        vertical-align: middle;
    }

    .table-modern tbody tr:hover {
        background-color: #fafcff;
    }

    /* Badges modernos */
    .badge-success-modern {
        background: #e0f2e9;
        color: #1e7e34;
        padding: 4px 12px;
        border-radius: 40px;
        font-weight: 500;
        font-size: 0.75rem;
    }

    .badge-danger-modern {
        background: #fee9e6;
        color: #c0392b;
        padding: 4px 12px;
        border-radius: 40px;
        font-weight: 500;
        font-size: 0.75rem;
    }

    /* Botones de acción (Editar y Toggle) */
    .btn-action {
        background: none;
        border: 1px solid #cbd5e1;
        border-radius: 30px;
        padding: 5px 14px;
        font-size: 0.75rem;
        font-weight: 500;
        color: #2c7da0;
        transition: all 0.2s;
        margin-right: 6px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-action i {
        font-size: 0.8rem;
    }

    .btn-action:hover {
        background: #2c7da0;
        border-color: #2c7da0;
        color: white;
    }

    .btn-toggle-success {
        background: #e0f2e9;
        border: 1px solid #1e7e34;
        border-radius: 30px;
        padding: 5px 14px;
        font-size: 0.75rem;
        font-weight: 500;
        color: #1e7e34;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-toggle-success:hover {
        background: #1e7e34;
        color: white;
    }

    .btn-toggle-warning {
        background: #fff3e0;
        border: 1px solid #e67e22;
        border-radius: 30px;
        padding: 5px 14px;
        font-size: 0.75rem;
        font-weight: 500;
        color: #e67e22;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-toggle-warning:hover {
        background: #e67e22;
        color: white;
    }

    /* Personalización de DataTables */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e2e8f0;
        border-radius: 40px;
        padding: 8px 16px;
        background-color: white;
        font-size: 0.85rem;
        width: 260px;
        transition: all 0.2s;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: #2c7da0;
        box-shadow: 0 0 0 3px rgba(44,125,160,0.1);
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #e2e8f0;
        border-radius: 30px;
        padding: 5px 24px 5px 12px;
        background-color: white;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 30px !important;
        border: none !important;
        margin: 0 2px;
        padding: 6px 12px;
        background: transparent;
        color: #2d3a4b !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #2c7da0 !important;
        color: white !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #eef2ff !important;
        color: #1f5e7e !important;
    }

    .dataTables_wrapper .dataTables_info {
        font-size: 0.8rem;
        color: #5b6e8c;
        padding-top: 12px;
    }

    /* Animación fadeIn */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px);}
        to { opacity: 1; transform: translateY(0);}
    }

    /* Responsive */
    @media (max-width: 640px) {
        .dashboard-container { padding: 16px; }
        .schedule-section { padding: 18px; }
        .section-header { flex-direction: column; align-items: flex-start; gap: 12px; }
        .dataTables_wrapper .dataTables_filter input { width: 100%; }
        .btn-action, .btn-toggle-success, .btn-toggle-warning { margin-bottom: 5px; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="dashboard-container">
    <!-- Encabezado estilo dashboard -->
    <div class="page-header">
        <div class="header-title">
            <i class="icofont icofont-ui-clock"></i>
            <div>
                <h4>Catálogo de Horarios de Citas</h4>
                <span>Gestión de bloques horarios para citas</span>
            </div>
        </div>
        <div class="update-badge">
            <i class="icofont icofont-calendar"></i> Administración
        </div>
    </div>

    <!-- Tarjeta principal con tabla -->
    <div class="schedule-section">
        <div class="section-header">
            <h5><i class="icofont icofont-list"></i> Lista de bloques horarios</h5>
            <button class="btn-modern" data-toggle="modal" data-target="#modalAgregarHoraCita">
                <i class="ti-plus"></i> Agregar Bloque
            </button>
        </div>

        <div class="modern-table-wrapper">
            <table id="tbl_horas_cita" class="table-modern" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hora de Inicio</th>
                        <th>Hora de Fin</th>
                        <th>Etiqueta</th>
                        <th>Turno</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los datos se llenan vía DataTable -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        cargarTablaHoraCita();
    });

    function cargarTablaHoraCita() {
        $('#tbl_horas_cita').DataTable({
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            paging: true,
            destroy: true,
            ajax: {
                url: '_actions/datasource_hora_cita.php',
                type: 'GET',
                dataSrc: ''
            },
            columns: [
                { data: 'id_hora' },
                { data: 'hora_inicio', render: function(data) { return (data || '').substring(0, 5); } },
                { data: 'hora_fin', render: function(data) { return (data || '').substring(0, 5); } },
                { data: 'etiqueta' },
                { data: 'turno' },
                {
                    data: 'activo',
                    render: function (data) {
                        return Number(data) === 1
                            ? '<span class="badge-success-modern">Activo</span>'
                            : '<span class="badge-danger-modern">Inactivo</span>';
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        // Escapamos valores para prevenir XSS
                        const id = escapeHtmlStatic(row.id_hora);
                        const inicio = escapeHtmlStatic((row.hora_inicio || '').substring(0, 5));
                        const fin = escapeHtmlStatic((row.hora_fin || '').substring(0, 5));
                        const etiqueta = escapeHtmlStatic(row.etiqueta || '');
                        const turno = escapeHtmlStatic(row.turno || '');
                        const activo = escapeHtmlStatic(row.activo);
                        const nuevoEstado = Number(row.activo) === 1 ? 0 : 1;
                        const textoToggle = Number(row.activo) === 1 ? 'Desactivar' : 'Activar';
                        const claseToggle = Number(row.activo) === 1 ? 'btn-toggle-warning' : 'btn-toggle-success';

                        return `
                            <button class="btn-action" data-toggle="modal" data-target="#modalEditarHoraCita"
                                onclick="editarHoraCita('${id}','${inicio}','${fin}','${etiqueta}','${turno}','${activo}')">
                                <i class="ti-pencil"></i> Editar
                            </button>
                            <button class="${claseToggle}" onclick="toggleHoraCita('${id}','${nuevoEstado}')">
                                <i class="ti-power-off"></i> ${textoToggle}
                            </button>
                        `;
                    }
                }
            ],
            language: {
                emptyTable: "No hay horarios registrados",
                info: "_START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "No hay registros para mostrar",
                lengthMenu: "Mostrar _MENU_ registros",
                loadingRecords: "Cargando...",
                processing: "Procesando...",
                search: "Buscar:",
                zeroRecords: "No se encontraron resultados",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }
        });
    }

    // Función auxiliar para escape HTML
    function escapeHtmlStatic(str) {
        if (!str) return '';
        return String(str).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    function editarHoraCita(id, inicio, fin, etiqueta, turno, activo) {
        $('#e_id_hora').val(id);
        $('#e_hora_inicio').val(inicio);
        $('#e_hora_fin').val(fin);
        $('#e_etiqueta').val(etiqueta);
        $('#e_turno').val(turno);
        $('#e_activo').val(activo);
    }

function toggleHoraCita(idHora, activo) {
    fetch('_actions/toggle_hora_cita.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id_hora=${encodeURIComponent(idHora)}&activo=${encodeURIComponent(activo)}`
    })
    .then(r => r.json())
    .then(resp => {
        if (resp.success) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: resp.message || 'Estatus actualizado.',
                timer: 1500,
                showConfirmButton: false
            });

            $('#tbl_horas_cita').DataTable().ajax.reload(null, false);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: resp.message || 'No se pudo actualizar.'
            });
        }
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'No se pudo cambiar el estatus.'
        });
    });
}

    function eliminarHoraCita(idHora) {
        if (!confirm('Esta acción eliminará el horario. ¿Deseas continuar?')) {
            return;
        }

        fetch('_actions/eliminar_hora_cita.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id_hora=${encodeURIComponent(idHora)}`
        })
        .then(r => r.json())
        .then(resp => {
            alert(resp.message || (resp.success ? 'Horario eliminado.' : 'No se pudo eliminar.'));
            if (resp.success) {
                $('#tbl_horas_cita').DataTable().ajax.reload(null, false);
            }
        })
        .catch(() => alert('Error de conexión al eliminar.'));
    }
</script>

<?php include __DIR__ . '/frm_modals_hora_cita.php'; ?>