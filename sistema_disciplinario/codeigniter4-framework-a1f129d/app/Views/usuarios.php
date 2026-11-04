<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Usuarios y Maestros - Sistema Disciplinario</title>

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
                        <a class="nav-link active fw-semibold" href="<?= site_url('usuarios') ?>">
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
            <div class="card-header bg-dark text-white p-3 p-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h1 class="h4 mb-0 fw-bold">
                        <i class="bi bi-person-gear me-2 text-warning"></i>
                        Gestión de Usuarios y Maestros
                    </h1>
                    <small class="text-white-50">Crea nuevos docentes, asígnales grados de responsabilidad y gestiona credenciales de acceso</small>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= site_url('reportes') ?>" class="btn btn-outline-light fw-semibold">
                        <i class="bi bi-journal-text me-1"></i> Ver Reportes de Maestros
                    </a>
                    <a href="<?= site_url('usuarios/crear') ?>" class="btn btn-primary fw-bold shadow-sm">
                        <i class="bi bi-person-plus-fill me-1"></i>
                        Registrar Nuevo Maestro / Usuario
                    </a>
                </div>
            </div>

            <div class="card-body p-3 p-md-4">

                <!-- BARRA DE BÚSQUEDA Y FILTROS -->
                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-6">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text"
                                   id="inputBusquedaUsuarios"
                                   class="form-control form-control-lg border-2 shadow-sm"
                                   placeholder="Buscar por nombre, correo, grado a cargo..."
                                   autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                            <button type="button" class="btn btn-outline-dark btn-sm active filter-btn-usr" data-filtro="todos">
                                <i class="bi bi-people-fill me-1"></i> Todos
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm filter-btn-usr" data-filtro="docentes">
                                <i class="bi bi-person-video3 me-1"></i> Maestros / Docentes
                            </button>
                            <button type="button" class="btn btn-outline-warning btn-sm filter-btn-usr" data-filtro="admins">
                                <i class="bi bi-shield-lock-fill me-1"></i> Administradores
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm filter-btn-usr" data-filtro="activos">
                                <i class="bi bi-check-circle me-1"></i> Activos
                            </button>
                            <button type="button" id="btnLimpiarUsr" class="btn btn-light btn-sm text-secondary border" title="Limpiar búsqueda">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small">
                        Mostrando <strong id="contadorUsuarios"><?= count($usuarios) ?></strong> de <?= count($usuarios) ?> usuario(s)
                    </span>
                    <small class="text-muted">
                        <i class="bi bi-shield-check text-success me-1"></i> Los maestros creados aquí están disponibles para registrar y firmar reportes
                    </small>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle table-bordered" id="tablaUsuarios">
                        <thead class="table-dark table-custom">
                            <tr>
                                <th class="text-center" style="width: 50px;">ID</th>
                                <th>Nombre Completo</th>
                                <th>Correo Electrónico & Teléfono</th>
                                <th>Rol del Sistema</th>
                                <th>Grado / Responsabilidad</th>
                                <th class="text-center">Reportes</th>
                                <th class="text-center" style="width: 100px;">Estado</th>
                                <th class="text-center" style="width: 200px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($usuarios)): ?>
                                <?php foreach ($usuarios as $u): ?>
                                <?php
                                    $esDocente = ($u['rol_id'] == 2);
                                    $esAdmin = ($u['rol_id'] == 1);
                                    $totalReportes = (int) ($u['total_reportes'] ?? 0);
                                    $esPropiaCuenta = ($u['usuarios_id'] == session('usuario_id'));
                                ?>
                                <tr class="fila-usuario"
                                    data-nombre="<?= strtolower(esc($u['nombres'] . ' ' . $u['apellidos'])) ?>"
                                    data-correo="<?= strtolower(esc($u['correo_electronico'])) ?>"
                                    data-rol="<?= $u['rol_id'] ?>"
                                    data-estado="<?= strtolower(esc($u['estado'])) ?>"
                                    data-grado="<?= strtolower(esc($u['grado_encargado'] ?? '')) ?>">

                                    <td class="text-center fw-bold text-muted"><?= esc($u['usuarios_id']) ?></td>

                                    <td>
                                        <div class="fw-bold text-dark fs-6 d-flex align-items-center">
                                            <i class="bi <?= $esDocente ? 'bi-person-video3 text-primary' : ($esAdmin ? 'bi-shield-check text-warning' : 'bi-person text-secondary') ?> me-2 fs-5"></i>
                                            <?= esc($u['nombres']) ?> <?= esc($u['apellidos']) ?>
                                            <?php if ($esPropiaCuenta): ?>
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle ms-2 small">Tú</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="fw-semibold text-secondary small">
                                            <i class="bi bi-envelope-at me-1 text-primary"></i><?= esc($u['correo_electronico']) ?>
                                        </div>
                                        <?php if (!empty($u['telefono'])): ?>
                                            <div class="small text-muted">
                                                <i class="bi bi-telephone me-1 text-success"></i><?= esc($u['telefono']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if ($esAdmin): ?>
                                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">
                                                <i class="bi bi-shield-lock-fill me-1"></i> Administrador
                                            </span>
                                        <?php elseif ($esDocente): ?>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                                <i class="bi bi-mortarboard-fill me-1"></i> Docente
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle px-2 py-1">
                                                <i class="bi bi-person-heart me-1"></i> Encargado
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if ($esDocente): ?>
                                            <?php if (!empty($u['grado_encargado']) && $u['grado_encargado'] !== 'Sin asignar'): ?>
                                                <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">
                                                    <i class="bi bi-building me-1"></i> <?= esc($u['grado_encargado']) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted small fst-italic">Docente General</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted small">—</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <?php if ($esDocente): ?>
                                            <a href="<?= site_url('reportes?docente=' . urlencode($u['nombres'] . ' ' . $u['apellidos'])) ?>"
                                               class="badge <?= $totalReportes > 0 ? 'bg-danger-subtle text-danger border border-danger-subtle' : 'bg-light text-secondary border' ?> text-decoration-none px-2 py-1"
                                               title="Ver reportes realizados por este docente">
                                                <i class="bi bi-journal-text me-1"></i> <?= $totalReportes ?> reporte(s)
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">—</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <?php if ($u['estado'] === 'Activo'): ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactivo</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Editar Usuario -->
                                            <a href="<?= site_url('usuarios/editar/' . $u['usuarios_id']) ?>"
                                               class="btn btn-warning btn-sm"
                                               title="Editar usuario y credenciales">
                                                <i class="bi bi-pencil-square"></i> Editar
                                            </a>

                                            <?php if (!$esPropiaCuenta): ?>
                                                <!-- Alternar Estado -->
                                                <form action="<?= site_url('usuarios/alternar-estado/' . $u['usuarios_id']) ?>"
                                                      method="post"
                                                      class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <button type="submit"
                                                            class="btn btn-outline-secondary btn-sm"
                                                            title="<?= $u['estado'] === 'Activo' ? 'Desactivar acceso' : 'Activar acceso' ?>">
                                                        <i class="bi <?= $u['estado'] === 'Activo' ? 'bi-pause-circle text-danger' : 'bi-play-circle text-success' ?>"></i>
                                                    </button>
                                                </form>

                                                <!-- Eliminar Usuario -->
                                                <form action="<?= site_url('usuarios/eliminar/' . $u['usuarios_id']) ?>"
                                                      method="post"
                                                      class="d-inline"
                                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar a <?= esc($u['nombres']) ?> <?= esc($u['apellidos']) ?>?');">
                                                    <?= csrf_field() ?>
                                                    <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            title="Eliminar usuario">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bi bi-people fs-1 d-block mb-2"></i>
                                        No hay usuarios registrados.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Mensaje si la búsqueda no encuentra resultados -->
                    <div id="sinResultadosUsr" class="text-center py-5 text-muted d-none">
                        <i class="bi bi-search fs-1 d-block mb-2 text-secondary"></i>
                        <h6 class="fw-bold">No se encontraron usuarios</h6>
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
            const inputBusqueda = document.getElementById('inputBusquedaUsuarios');
            const btnLimpiar = document.getElementById('btnLimpiarUsr');
            const filterBtns = document.querySelectorAll('.filter-btn-usr');
            const filas = document.querySelectorAll('.fila-usuario');
            const contador = document.getElementById('contadorUsuarios');
            const sinResultados = document.getElementById('sinResultadosUsr');

            let filtroActual = 'todos';

            function filtrar() {
                const query = inputBusqueda.value.toLowerCase().trim();
                let visibles = 0;

                filas.forEach(fila => {
                    const nombre = fila.getAttribute('data-nombre') || '';
                    const correo = fila.getAttribute('data-correo') || '';
                    const rol = fila.getAttribute('data-rol') || '';
                    const estado = fila.getAttribute('data-estado') || '';
                    const grado = fila.getAttribute('data-grado') || '';

                    // Texto
                    const coincideTexto = query === '' ||
                                          nombre.includes(query) ||
                                          correo.includes(query) ||
                                          grado.includes(query);

                    // Filtros rápidos
                    let coincideFiltro = true;
                    if (filtroActual === 'docentes') {
                        coincideFiltro = (rol === '2');
                    } else if (filtroActual === 'admins') {
                        coincideFiltro = (rol === '1');
                    } else if (filtroActual === 'activos') {
                        coincideFiltro = (estado === 'activo');
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

            inputBusqueda.addEventListener('input', filtrar);

            btnLimpiar.addEventListener('click', function () {
                inputBusqueda.value = '';
                filtroActual = 'todos';
                filterBtns.forEach(btn => btn.classList.toggle('active', btn.getAttribute('data-filtro') === 'todos'));
                filtrar();
                inputBusqueda.focus();
            });

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    filtroActual = this.getAttribute('data-filtro');
                    filtrar();
                });
            });
        });
    </script>
</body>
</html>
