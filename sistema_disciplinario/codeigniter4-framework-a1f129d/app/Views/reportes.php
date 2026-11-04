<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reportes Disciplinarios - Sistema Disciplinario</title>

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons 1.11.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            min-height: 100vh;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
        }

        .table-custom th {
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.8rem;
        }

        .search-box {
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1.1rem;
        }

        .search-box input {
            padding-left: 45px;
            border-radius: 2rem;
            padding-top: 0.6rem;
            padding-bottom: 0.6rem;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= site_url('inicio') ?>">
                <i class="bi bi-mortarboard-fill me-2 fs-4"></i>
                <span>Sistema Disciplinario</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Navegación">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="<?= site_url('inicio') ?>">
                            <i class="bi bi-house-door-fill me-1"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="<?= site_url('estudiantes') ?>">
                            <i class="bi bi-people-fill me-1"></i> Estudiantes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" href="<?= site_url('reportes') ?>">
                            <i class="bi bi-journal-x me-1"></i> Reportes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="<?= site_url('grados') ?>">
                            <i class="bi bi-building me-1"></i> Grados y Secciones
                        </a>
                    </li>
                    <?php if (session()->get('rol_id') == 1): ?>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="<?= site_url('usuarios') ?>">
                            <i class="bi bi-person-gear me-1"></i> Usuarios y Maestros
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="<?= site_url('inicio') ?>" class="btn btn-outline-light btn-sm fw-semibold">
                    <i class="bi bi-house-door-fill me-1"></i> Panel
                </a>
                <a href="<?= site_url('logout') ?>" class="btn btn-outline-light btn-sm fw-semibold">
                    <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-2">

        <!-- Mensajes de Éxito / Error -->
        <?php if (session()->getFlashdata('exito')): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                <div><?= esc(session()->getFlashdata('exito')) ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                <div><?= esc(session()->getFlashdata('error')) ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-danger text-white p-3 p-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h1 class="h4 mb-0 fw-bold">
                        <i class="bi bi-journal-x me-2"></i>
                        Supervisión de Reportes Disciplinarios
                    </h1>
                    <small class="text-white-50">Consulta y da seguimiento a los reportes de conducta ingresados por los maestros</small>
                </div>

                <div class="d-flex gap-2">
                    <?php if (session()->get('rol_id') == 1): ?>
                    <a href="<?= site_url('usuarios') ?>" class="btn btn-outline-light fw-semibold">
                        <i class="bi bi-person-video3 me-1"></i> Gestionar Maestros
                    </a>
                    <?php endif; ?>
                    <a href="<?= site_url('reportes/crear') ?>" class="btn btn-light text-danger fw-bold shadow-sm">
                        <i class="bi bi-file-earmark-plus-fill me-1"></i>
                        Crear Nuevo Reporte
                    </a>
                </div>
            </div>

            <div class="card-body p-3 p-md-4">

                <!-- BARRA DE BÚSQUEDA Y FILTRADO AVANZADO -->
                <div class="row g-3 align-items-center mb-4">
                    <!-- Cuadro de texto -->
                    <div class="col-lg-5">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text"
                                   id="inputBusquedaReportes"
                                   class="form-control form-control-lg border-2 shadow-sm"
                                   placeholder="Buscar por estudiante, maestro, motivo o falta..."
                                   value="<?= esc($docente_filtro ?? '') ?>"
                                   autocomplete="off">
                        </div>
                    </div>

                    <!-- Filtro por Maestro / Docente -->
                    <div class="col-md-4 col-lg-3">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-light text-secondary"><i class="bi bi-person-badge"></i></span>
                            <select id="selectFiltroDocente" class="form-select">
                                <option value="">Todos los maestros...</option>
                                <?php if (!empty($docentes)): ?>
                                    <?php foreach ($docentes as $doc): ?>
                                        <?php $nombreDocente = $doc['nombre'] . ' ' . $doc['apellido']; ?>
                                        <option value="<?= strtolower(esc($nombreDocente)) ?>" <?= (!empty($docente_filtro) && stripos($docente_filtro, $doc['nombre']) !== false) ? 'selected' : '' ?>>
                                            Prof(a). <?= esc($nombreDocente) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Filtro por Estado -->
                    <div class="col-md-4 col-lg-2">
                        <select id="selectFiltroEstado" class="form-select shadow-sm">
                            <option value="">Todos los estados</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="en proceso">En Proceso</option>
                            <option value="resuelto">Resuelto</option>
                            <option value="archivado">Archivado</option>
                        </select>
                    </div>

                    <!-- Botón Limpiar -->
                    <div class="col-md-4 col-lg-2 text-md-end">
                        <button type="button" id="btnLimpiarFiltros" class="btn btn-outline-secondary w-100 shadow-sm">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Limpiar Filtros
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small">
                        Mostrando <strong id="contadorReportes"><?= count($reportes) ?></strong> de <?= count($reportes) ?> reporte(s)
                    </span>
                    <small class="text-muted">
                        <i class="bi bi-eye text-primary me-1"></i> Haz clic en el botón de ver detalle para consultar las acciones tomadas
                    </small>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle table-bordered" id="tablaReportes">
                        <thead class="table-dark table-custom">
                            <tr>
                                <th class="text-center" style="width: 50px;">ID</th>
                                <th>Estudiante</th>
                                <th>Maestro / Docente que Reporta</th>
                                <th>Falta & Gravedad</th>
                                <th>Motivo del Reporte</th>
                                <th>Fecha & Hora</th>
                                <th>Estado</th>
                                <th class="text-center" style="width: 200px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($reportes)): ?>
                                <?php foreach ($reportes as $rep): ?>
                                <?php
                                    $nombreMaestro = ($rep['doc_nombre'] ?? '') . ' ' . ($rep['doc_apellido'] ?? '');
                                    $nombreEstudiante = ($rep['est_nombres'] ?? '') . ' ' . ($rep['est_apellidos'] ?? '');
                                ?>
                                <tr class="fila-reporte"
                                    data-maestro="<?= strtolower(esc($nombreMaestro)) ?>"
                                    data-estudiante="<?= strtolower(esc($nombreEstudiante)) ?>"
                                    data-falta="<?= strtolower(esc($rep['falta_nombre'] ?? '')) ?>"
                                    data-motivo="<?= strtolower(esc($rep['motivo'] ?? '')) ?>"
                                    data-estado="<?= strtolower(esc($rep['estado_nombre'] ?? '')) ?>"
                                    data-gravedad="<?= strtolower(esc($rep['falta_gravedad'] ?? '')) ?>">

                                    <td class="text-center fw-bold text-muted"><?= esc($rep['reporte_id']) ?></td>

                                    <!-- Estudiante -->
                                    <td>
                                        <div class="fw-bold text-dark">
                                            <?= esc($rep['est_nombres']) ?> <?= esc($rep['est_apellidos']) ?>
                                        </div>
                                        <?php if (!empty($rep['nombre_grado'])): ?>
                                            <span class="badge bg-light text-secondary border small">
                                                <?= esc($rep['nombre_grado']) ?> - Sec. <?= esc($rep['nombre_seccion']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Maestro que reporta -->
                                    <td>
                                        <div class="fw-semibold text-primary d-flex align-items-center">
                                            <i class="bi bi-person-badge-fill me-2 fs-5"></i>
                                            <div>
                                                <span>Prof(a). <?= esc($rep['doc_nombre']) ?> <?= esc($rep['doc_apellido']) ?></span>
                                                <div class="small text-muted fw-normal">Docente informante</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Falta & Gravedad -->
                                    <td>
                                        <div class="small fw-semibold text-dark"><?= esc($rep['falta_nombre']) ?></div>
                                        <?php
                                            $badgeClass = 'bg-secondary';
                                            if ($rep['falta_gravedad'] === 'Leve') $badgeClass = 'bg-warning text-dark';
                                            elseif ($rep['falta_gravedad'] === 'Moderada') $badgeClass = 'bg-warning-subtle text-dark border border-warning';
                                            elseif ($rep['falta_gravedad'] === 'Grave') $badgeClass = 'bg-danger text-white';
                                        ?>
                                        <span class="badge <?= $badgeClass ?> small">
                                            <?= esc($rep['falta_gravedad']) ?>
                                        </span>
                                    </td>

                                    <!-- Motivo -->
                                    <td>
                                        <span class="text-dark fw-medium small"><?= esc($rep['motivo']) ?></span>
                                    </td>

                                    <!-- Fecha y Hora -->
                                    <td>
                                        <div class="small">
                                            <i class="bi bi-calendar3 me-1 text-muted"></i>
                                            <?= esc(date('d/m/Y', strtotime($rep['fecha']))) ?>
                                        </div>
                                        <div class="small text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            <?= esc(date('H:i', strtotime($rep['hora']))) ?>
                                        </div>
                                    </td>

                                    <!-- Estado -->
                                    <td>
                                        <?php
                                            $estadoClass = 'bg-secondary';
                                            if ($rep['estado_nombre'] === 'Pendiente') $estadoClass = 'bg-warning-subtle text-warning-emphasis border border-warning-subtle';
                                            elseif ($rep['estado_nombre'] === 'En Proceso') $estadoClass = 'bg-info-subtle text-info-emphasis border border-info-subtle';
                                            elseif ($rep['estado_nombre'] === 'Resuelto') $estadoClass = 'bg-success-subtle text-success border border-success-subtle';
                                        ?>
                                        <span class="badge <?= $estadoClass ?>">
                                            <?= esc($rep['estado_nombre']) ?>
                                        </span>
                                    </td>

                                    <!-- Acciones -->
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Ver detalle -->
                                            <button type="button"
                                                    class="btn btn-info btn-sm text-white"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDetalle<?= $rep['reporte_id'] ?>"
                                                    title="Ver reporte completo">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>

                                            <!-- Imprimir / PDF -->
                                            <a href="<?= site_url('reportes/imprimir/' . $rep['reporte_id']) ?>"
                                               target="_blank"
                                               class="btn btn-outline-dark btn-sm"
                                               title="Imprimir o guardar como PDF">
                                                <i class="bi bi-printer-fill"></i>
                                            </a>

                                            <!-- Descargar Word -->
                                            <a href="<?= site_url('reportes/descargar-word/' . $rep['reporte_id']) ?>"
                                               class="btn btn-outline-primary btn-sm"
                                               title="Descargar reporte en Word (.doc)">
                                                <i class="bi bi-file-earmark-word-fill"></i>
                                            </a>

                                            <!-- Eliminar -->
                                            <form action="<?= site_url('reportes/eliminar/' . $rep['reporte_id']) ?>"
                                                  method="post"
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Estás seguro de que deseas eliminar este reporte?');">
                                                <?= csrf_field() ?>
                                                <button type="submit"
                                                        class="btn btn-outline-danger btn-sm"
                                                        title="Eliminar reporte">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Modal de Detalle Completo -->
                                        <div class="modal fade" id="modalDetalle<?= $rep['reporte_id'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $rep['reporte_id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered text-start">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title h6 fw-bold" id="modalLabel<?= $rep['reporte_id'] ?>">
                                                            <i class="bi bi-journal-text me-1"></i> Expediente de Reporte #<?= esc($rep['reporte_id']) ?>
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <div class="p-3 bg-light rounded border mb-3">
                                                            <div class="row g-2">
                                                                <div class="col-7">
                                                                    <span class="text-muted small d-block">Estudiante:</span>
                                                                    <strong class="fs-6"><?= esc($rep['est_nombres']) ?> <?= esc($rep['est_apellidos']) ?></strong>
                                                                    <div class="small text-muted">
                                                                        <?= esc($rep['nombre_grado'] ?? '') ?> - Sec. <?= esc($rep['nombre_seccion'] ?? '') ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-5 text-end">
                                                                    <span class="text-muted small d-block">Fecha:</span>
                                                                    <span class="badge bg-dark"><?= esc(date('d/m/Y', strtotime($rep['fecha']))) ?></span>
                                                                    <div class="small text-muted"><?= esc(date('H:i', strtotime($rep['hora']))) ?></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="p-3 bg-primary-subtle rounded border border-primary-subtle mb-3">
                                                            <span class="text-primary small d-block fw-semibold">Maestro / Docente que elaboró el reporte:</span>
                                                            <strong class="text-dark fs-6">
                                                                <i class="bi bi-person-badge me-1 text-primary"></i> Prof(a). <?= esc($rep['doc_nombre']) ?> <?= esc($rep['doc_apellido']) ?>
                                                            </strong>
                                                        </div>

                                                        <div class="mb-3">
                                                            <span class="text-muted small d-block">Tipo de Falta cometida:</span>
                                                            <strong class="text-dark"><?= esc($rep['falta_nombre']) ?></strong>
                                                            <span class="badge <?= $badgeClass ?> ms-1"><?= esc($rep['falta_gravedad']) ?></span>
                                                        </div>

                                                        <div class="mb-3">
                                                            <span class="text-muted small d-block">Motivo del reporte:</span>
                                                            <div class="p-2 bg-light rounded fw-semibold text-dark">
                                                                <?= esc($rep['motivo']) ?>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <span class="text-muted small d-block">Descripción detallada de los hechos:</span>
                                                            <p class="p-2 bg-light rounded text-secondary mb-0 small">
                                                                <?= nl2br(esc($rep['descripcion_falta'])) ?>
                                                            </p>
                                                        </div>

                                                        <?php if (!empty($rep['acciones_tomadas'])): ?>
                                                        <div class="mb-3">
                                                            <span class="text-muted small d-block">Acciones o medidas disciplinarias tomadas:</span>
                                                            <p class="p-2 bg-success-subtle rounded text-success-emphasis mb-0 small">
                                                                <i class="bi bi-check2-circle me-1"></i><?= nl2br(esc($rep['acciones_tomadas'])) ?>
                                                            </p>
                                                        </div>
                                                        <?php endif; ?>

                                                        <div class="pt-2 border-top d-flex justify-content-between align-items-center">
                                                            <span class="small text-muted">Estado actual del reporte:</span>
                                                            <span class="badge <?= $estadoClass ?> fs-6"><?= esc($rep['estado_nombre']) ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer d-flex justify-content-between align-items-center">
                                                        <div class="d-flex gap-2">
                                                            <a href="<?= site_url('reportes/imprimir/' . $rep['reporte_id']) ?>"
                                                               target="_blank"
                                                               class="btn btn-dark btn-sm">
                                                                <i class="bi bi-printer-fill me-1"></i> Imprimir / PDF
                                                            </a>
                                                            <a href="<?= site_url('reportes/descargar-word/' . $rep['reporte_id']) ?>"
                                                               class="btn btn-primary btn-sm">
                                                                <i class="bi bi-file-earmark-word-fill me-1"></i> Descargar Word (.doc)
                                                            </a>
                                                        </div>
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bi bi-check2-all fs-1 d-block mb-2 text-success"></i>
                                        No hay reportes disciplinarios registrados.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Mensaje si la búsqueda no encuentra resultados -->
                    <div id="sinResultadosReportes" class="text-center py-5 text-muted d-none">
                        <i class="bi bi-search fs-1 d-block mb-2 text-secondary"></i>
                        <h6 class="fw-bold">No se encontraron reportes</h6>
                        <p class="small mb-0">Intenta con otro término o limpia los filtros.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script de Búsqueda y Filtrado en Tiempo Real -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputBusqueda = document.getElementById('inputBusquedaReportes');
            const selectDocente = document.getElementById('selectFiltroDocente');
            const selectEstado = document.getElementById('selectFiltroEstado');
            const btnLimpiar = document.getElementById('btnLimpiarFiltros');
            const filas = document.querySelectorAll('.fila-reporte');
            const contador = document.getElementById('contadorReportes');
            const sinResultados = document.getElementById('sinResultadosReportes');

            function filtrar() {
                const query = inputBusqueda.value.toLowerCase().trim();
                const docenteFiltro = selectDocente.value.toLowerCase().trim();
                const estadoFiltro = selectEstado.value.toLowerCase().trim();

                let visibles = 0;

                filas.forEach(fila => {
                    const maestro = fila.getAttribute('data-maestro') || '';
                    const estudiante = fila.getAttribute('data-estudiante') || '';
                    const falta = fila.getAttribute('data-falta') || '';
                    const motivo = fila.getAttribute('data-motivo') || '';
                    const estado = fila.getAttribute('data-estado') || '';

                    // Coincidencia con cuadro de búsqueda
                    const coincideTexto = query === '' ||
                                          maestro.includes(query) ||
                                          estudiante.includes(query) ||
                                          falta.includes(query) ||
                                          motivo.includes(query);

                    // Coincidencia con select de docente
                    const coincideDocente = docenteFiltro === '' || maestro.includes(docenteFiltro);

                    // Coincidencia con select de estado
                    const coincideEstado = estadoFiltro === '' || estado.includes(estadoFiltro);

                    if (coincideTexto && coincideDocente && coincideEstado) {
                        fila.style.display = '';
                        visibles++;
                    } else {
                        fila.style.display = 'none';
                    }
                });

                contador.textContent = visibles;
                sinResultados.classList.toggle('d-none', visibles > 0);
            }

            inputBusqueda.addEventListener('input', filtrar);
            selectDocente.addEventListener('change', filtrar);
            selectEstado.addEventListener('change', filtrar);

            btnLimpiar.addEventListener('click', function () {
                inputBusqueda.value = '';
                selectDocente.value = '';
                selectEstado.value = '';
                filtrar();
                inputBusqueda.focus();
            });

            // Si hay un filtro inicial (ej. parámetro GET)
            if (inputBusqueda.value.trim() !== '' || selectDocente.value !== '') {
                filtrar();
            }
        });
    </script>
</body>
</html>
