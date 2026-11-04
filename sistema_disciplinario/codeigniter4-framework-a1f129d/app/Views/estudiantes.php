<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Estudiantes - Sistema Disciplinario</title>

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
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="<?= site_url('inicio') ?>">
                            <i class="bi bi-house-door-fill me-1"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" href="<?= site_url('estudiantes') ?>">
                            <i class="bi bi-people-fill me-1"></i> Estudiantes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="<?= site_url('reportes') ?>">
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
            <div class="card-header bg-primary text-white p-3 p-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h1 class="h4 mb-0 fw-bold">
                        <i class="bi bi-people-fill me-2"></i>
                        Administración y Consulta de Estudiantes
                    </h1>
                    <small class="text-white-50">Busca estudiantes y consulta su historial de reportes disciplinarios</small>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= site_url('reportes') ?>" class="btn btn-outline-light fw-semibold">
                        <i class="bi bi-journal-x me-1"></i>
                        Ver Reportes
                    </a>
                    <a href="<?= site_url('estudiantes/crear') ?>" class="btn btn-success fw-semibold shadow-sm">
                        <i class="bi bi-person-plus-fill me-1"></i>
                        Registrar Estudiante
                    </a>
                </div>
            </div>

            <div class="card-body p-3 p-md-4">

                <!-- BARRA DE BÚSQUEDA Y FILTROS -->
                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-7">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text"
                                   id="inputBusqueda"
                                   class="form-control form-control-lg border-2 shadow-sm"
                                   placeholder="Escribe el nombre, apellido, ID o grado del estudiante..."
                                   value="<?= esc($buscar ?? '') ?>"
                                   autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                            <button type="button" class="btn btn-outline-primary btn-sm active filter-btn" data-filtro="todos">
                                <i class="bi bi-people-fill me-1"></i> Todos
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm filter-btn" data-filtro="con-reportes">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Con Reportes
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm filter-btn" data-filtro="sin-reportes">
                                <i class="bi bi-check-circle-fill me-1"></i> Sin Reportes
                            </button>
                            <button type="button" id="btnLimpiarBusqueda" class="btn btn-light btn-sm text-secondary border" title="Limpiar búsqueda">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small">
                        Mostrando <strong id="contadorEstudiantes"><?= count($estudiantes) ?></strong> de <?= count($estudiantes) ?> estudiante(s)
                    </span>
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i> Haz clic en la insignia de reportes para ver el expediente del alumno
                    </small>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle table-bordered" id="tablaEstudiantes">
                        <thead class="table-dark table-custom">
                            <tr>
                                <th class="text-center" style="width: 50px;">ID</th>
                                <th>Estudiante</th>
                                <th>Grado y Sección</th>
                                <th>Género</th>
                                <th>Encargado / Contacto</th>
                                <th class="text-center" style="width: 170px;">Reportes</th>
                                <th class="text-center" style="width: 200px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($estudiantes)): ?>
                                <?php foreach ($estudiantes as $est): ?>
                                <?php
                                    $tieneReportes = ((int) $est['total_reportes']) > 0;
                                    $reportesAlumno = $reportes_por_estudiante[$est['estudiantes_id']] ?? [];
                                ?>
                                <tr class="fila-estudiante"
                                    data-nombre="<?= strtolower(esc($est['nombres'] . ' ' . $est['apellidos'])) ?>"
                                    data-grado="<?= strtolower(esc($est['nombre_grado'] ?? '')) ?>"
                                    data-seccion="<?= strtolower(esc($est['nombre_seccion'] ?? '')) ?>"
                                    data-id="<?= $est['estudiantes_id'] ?>"
                                    data-reportes="<?= $est['total_reportes'] ?>">

                                    <td class="text-center fw-bold text-muted"><?= esc($est['estudiantes_id']) ?></td>

                                    <td>
                                        <div class="fw-bold text-dark fs-6">
                                            <?= esc($est['nombres']) ?> <?= esc($est['apellidos']) ?>
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar-event me-1"></i><?= esc(date('d/m/Y', strtotime($est['fecha_nacimiento']))) ?>
                                        </small>
                                    </td>

                                    <td>
                                        <?php if (!empty($est['nombre_grado'])): ?>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                <i class="bi bi-mortarboard me-1"></i>
                                                <?= esc($est['nombre_grado']) ?> - Sec. <?= esc($est['nombre_seccion']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Sin asignar</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if ($est['genero'] === 'Masculino'): ?>
                                            <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">
                                                <i class="bi bi-gender-male"></i> Masculino
                                            </span>
                                        <?php elseif ($est['genero'] === 'Femenino'): ?>
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                                <i class="bi bi-gender-female"></i> Femenino
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark"><?= esc($est['genero']) ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($est['enc_nombre'])): ?>
                                            <div class="small fw-semibold">
                                                <?= esc($est['enc_nombre']) ?> <?= esc($est['enc_apellido']) ?>
                                                <span class="text-muted fw-normal">(<?= esc($est['enc_parentesco']) ?>)</span>
                                            </div>
                                            <div class="small text-muted">
                                                <i class="bi bi-telephone-fill text-success me-1"></i><?= esc($est['enc_telefono']) ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted small">No asignado</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- COLUMNA REPORTES DISCIPLINARIOS -->
                                    <td class="text-center">
                                        <?php if ($tieneReportes): ?>
                                            <button type="button"
                                                    class="btn btn-outline-danger btn-sm fw-bold shadow-sm px-2 py-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalReportes<?= $est['estudiantes_id'] ?>"
                                                    title="Ver historial de reportes">
                                                <i class="bi bi-exclamation-triangle-fill me-1 text-danger"></i>
                                                <?= esc($est['total_reportes']) ?> Reporte(s)
                                            </button>
                                        <?php else: ?>
                                            <button type="button"
                                                    class="btn btn-outline-success btn-sm px-2 py-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalReportes<?= $est['estudiantes_id'] ?>"
                                                    title="Expediente limpio">
                                                <i class="bi bi-check-circle-fill me-1 text-success"></i>
                                                Sin Reportes
                                            </button>
                                        <?php endif; ?>
                                    </td>

                                    <!-- ACCIONES -->
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Reportar estudiante -->
                                            <a href="<?= site_url('reportes/crear?estudiante_id=' . $est['estudiantes_id']) ?>"
                                               class="btn btn-outline-danger btn-sm"
                                               title="Crear reporte disciplinario">
                                                <i class="bi bi-journal-plus"></i>
                                                Reportar
                                            </a>

                                            <!-- Editar -->
                                            <a href="<?= site_url('estudiantes/editar/' . $est['estudiantes_id']) ?>"
                                               class="btn btn-warning btn-sm"
                                               title="Editar estudiante">
                                                <i class="bi bi-pencil-square"></i>
                                                Editar
                                            </a>

                                            <!-- Quitar -->
                                            <form action="<?= site_url('estudiantes/eliminar/' . $est['estudiantes_id']) ?>"
                                                  method="post"
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Estás seguro de que deseas eliminar a <?= esc($est['nombres']) ?> <?= esc($est['apellidos']) ?>?');">
                                                <?= csrf_field() ?>
                                                <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        title="Eliminar estudiante">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- MODAL EXPEDIENTE DISCIPLINARIO DEL ALUMNO -->
                                        <div class="modal fade" id="modalReportes<?= $est['estudiantes_id'] ?>" tabindex="-1" aria-labelledby="labelModal<?= $est['estudiantes_id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered text-start">
                                                <div class="modal-content">
                                                    <div class="modal-header <?= $tieneReportes ? 'bg-danger' : 'bg-success' ?> text-white">
                                                        <h5 class="modal-title h6 fw-bold" id="labelModal<?= $est['estudiantes_id'] ?>">
                                                            <i class="bi <?= $tieneReportes ? 'bi-shield-exclamation' : 'bi-shield-check' ?> me-2"></i>
                                                            Expediente Disciplinario: <?= esc($est['nombres']) ?> <?= esc($est['apellidos']) ?>
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                    </div>

                                                    <div class="modal-body p-4">
                                                        <!-- Datos del Estudiante -->
                                                        <div class="p-3 bg-light rounded border mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                            <div>
                                                                <strong class="d-block text-dark fs-6"><?= esc($est['nombres']) ?> <?= esc($est['apellidos']) ?></strong>
                                                                <span class="text-muted small">
                                                                    <?= esc($est['nombre_grado'] ?? 'Sin Grado') ?> - Sección <?= esc($est['nombre_seccion'] ?? '') ?>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <?php if ($tieneReportes): ?>
                                                                    <span class="badge bg-danger fs-6 px-3 py-2">
                                                                        <i class="bi bi-exclamation-octagon-fill me-1"></i> <?= count($reportesAlumno) ?> reporte(s) registrado(s)
                                                                    </span>
                                                                <?php else: ?>
                                                                    <span class="badge bg-success fs-6 px-3 py-2">
                                                                        <i class="bi bi-check-circle-fill me-1"></i> Expediente Limpio
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>

                                                        <!-- Historial de Reportes -->
                                                        <?php if (!empty($reportesAlumno)): ?>
                                                            <h6 class="fw-bold text-secondary mb-3">Historial de Incidencias:</h6>
                                                            <div class="d-flex flex-column gap-3">
                                                                <?php foreach ($reportesAlumno as $rep): ?>
                                                                    <div class="card border shadow-sm">
                                                                        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap py-2">
                                                                            <div>
                                                                                <strong class="text-dark">Reporte #<?= esc($rep['reporte_id']) ?>:</strong>
                                                                                <span class="text-primary fw-semibold"><?= esc($rep['falta_nombre']) ?></span>
                                                                                <?php
                                                                                    $bgGravedad = 'bg-secondary';
                                                                                    if ($rep['falta_gravedad'] === 'Leve') $bgGravedad = 'bg-warning text-dark';
                                                                                    elseif ($rep['falta_gravedad'] === 'Moderada') $bgGravedad = 'bg-warning-subtle text-dark border border-warning';
                                                                                    elseif ($rep['falta_gravedad'] === 'Grave') $bgGravedad = 'bg-danger text-white';
                                                                                ?>
                                                                                <span class="badge <?= $bgGravedad ?> ms-1"><?= esc($rep['falta_gravedad']) ?></span>
                                                                            </div>
                                                                            <div class="small text-muted">
                                                                                <i class="bi bi-calendar3 me-1"></i><?= esc(date('d/m/Y', strtotime($rep['fecha']))) ?>
                                                                                <i class="bi bi-clock ms-1 me-1"></i><?= esc(date('H:i', strtotime($rep['hora']))) ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-body p-3">
                                                                            <div class="mb-2">
                                                                                <strong class="small text-muted d-block">Motivo:</strong>
                                                                                <div class="fw-semibold text-dark"><?= esc($rep['motivo']) ?></div>
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong class="small text-muted d-block">Descripción de la Falta:</strong>
                                                                                <p class="small text-secondary mb-0 bg-light p-2 rounded">
                                                                                    <?= nl2br(esc($rep['descripcion_falta'])) ?>
                                                                                </p>
                                                                            </div>
                                                                            <?php if (!empty($rep['acciones_tomadas'])): ?>
                                                                                <div class="mb-2">
                                                                                    <strong class="small text-muted d-block">Acciones / Medidas Aplicadas:</strong>
                                                                                    <p class="small text-success-emphasis bg-success-subtle p-2 rounded mb-0">
                                                                                        <i class="bi bi-check2 me-1"></i><?= nl2br(esc($rep['acciones_tomadas'])) ?>
                                                                                    </p>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top small text-muted flex-wrap gap-2">
                                                                                <div>
                                                                                    <span>Reportado por: <strong>Prof. <?= esc($rep['doc_nombre']) ?> <?= esc($rep['doc_apellido']) ?></strong></span>
                                                                                    <span class="badge bg-secondary-subtle text-secondary-emphasis border ms-1">
                                                                                        <?= esc($rep['estado_nombre']) ?>
                                                                                    </span>
                                                                                </div>
                                                                                <div class="d-flex gap-1">
                                                                                    <a href="<?= site_url('reportes/imprimir/' . $rep['reporte_id']) ?>"
                                                                                       target="_blank"
                                                                                       class="btn btn-outline-dark btn-sm py-0 px-2"
                                                                                       title="Imprimir o guardar como PDF">
                                                                                        <i class="bi bi-printer-fill me-1"></i> Imprimir / PDF
                                                                                    </a>
                                                                                    <a href="<?= site_url('reportes/descargar-word/' . $rep['reporte_id']) ?>"
                                                                                       class="btn btn-outline-primary btn-sm py-0 px-2"
                                                                                       title="Descargar en Word (.doc)">
                                                                                        <i class="bi bi-file-earmark-word-fill me-1"></i> Word
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="text-center py-4">
                                                                <i class="bi bi-award fs-1 text-success d-block mb-2"></i>
                                                                <h6 class="fw-bold text-success">¡Excelente conducta!</h6>
                                                                <p class="text-muted small mb-0">
                                                                    Este alumno no tiene ninguna falta disciplinaria ni reporte registrado en el sistema.
                                                                </p>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="modal-footer d-flex justify-content-between">
                                                        <a href="<?= site_url('reportes/crear?estudiante_id=' . $est['estudiantes_id']) ?>"
                                                           class="btn btn-outline-danger btn-sm fw-semibold">
                                                            <i class="bi bi-plus-circle me-1"></i> Registrar Reporte para este Alumno
                                                        </a>
                                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                                            Cerrar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        No hay estudiantes registrados.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Mensaje si la búsqueda no encuentra resultados -->
                    <div id="sinResultadosBusqueda" class="text-center py-5 text-muted d-none">
                        <i class="bi bi-search fs-1 d-block mb-2 text-secondary"></i>
                        <h6 class="fw-bold">No se encontraron estudiantes</h6>
                        <p class="small mb-0">Intenta con otro término de búsqueda o limpia los filtros.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SCRIPT DE BÚSQUEDA Y FILTRADO EN TIEMPO REAL -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputBusqueda = document.getElementById('inputBusqueda');
            const btnLimpiar = document.getElementById('btnLimpiarBusqueda');
            const filterBtns = document.querySelectorAll('.filter-btn');
            const filas = document.querySelectorAll('.fila-estudiante');
            const contador = document.getElementById('contadorEstudiantes');
            const sinResultados = document.getElementById('sinResultadosBusqueda');

            let filtroActual = 'todos'; // 'todos', 'con-reportes', 'sin-reportes'

            function filtrarEstudiantes() {
                const query = inputBusqueda.value.toLowerCase().trim();
                let visibles = 0;

                filas.forEach(fila => {
                    const nombre = fila.getAttribute('data-nombre') || '';
                    const grado = fila.getAttribute('data-grado') || '';
                    const seccion = fila.getAttribute('data-seccion') || '';
                    const id = fila.getAttribute('data-id') || '';
                    const totalReportes = parseInt(fila.getAttribute('data-reportes'), 10) || 0;

                    // Coincidencia de texto
                    const coincideTexto = query === '' ||
                                          nombre.includes(query) ||
                                          grado.includes(query) ||
                                          seccion.includes(query) ||
                                          id.includes(query);

                    // Coincidencia de filtro de reportes
                    let coincideFiltro = true;
                    if (filtroActual === 'con-reportes') {
                        coincideFiltro = totalReportes > 0;
                    } else if (filtroActual === 'sin-reportes') {
                        coincideFiltro = totalReportes === 0;
                    }

                    if (coincideTexto && coincideFiltro) {
                        fila.style.display = '';
                        visibles++;
                    } else {
                        fila.style.display = 'none';
                    }
                });

                contador.textContent = visibles;
                sinResultados.classList.toggle('d-none', visibles > 0);
            }

            // Evento al escribir en la barra de búsqueda
            inputBusqueda.addEventListener('input', filtrarEstudiantes);

            // Botón de limpiar búsqueda
            btnLimpiar.addEventListener('click', function () {
                inputBusqueda.value = '';
                filtroActual = 'todos';
                filterBtns.forEach(btn => btn.classList.toggle('active', btn.getAttribute('data-filtro') === 'todos'));
                filtrarEstudiantes();
                inputBusqueda.focus();
            });

            // Botones de filtro rápido
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    filtroActual = this.getAttribute('data-filtro');
                    filtrarEstudiantes();
                });
            });

            // Ejecutar al cargar por si hay valor inicial
            if (inputBusqueda.value.trim() !== '') {
                filtrarEstudiantes();
            }
        });
    </script>
</body>
</html>
