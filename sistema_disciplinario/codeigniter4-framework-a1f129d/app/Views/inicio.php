<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal - Sistema Disciplinario</title>

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons 1.11.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
        }

        .card-menu {
            border: none;
            border-radius: 0.75rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-menu:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1) !important;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        footer {
            margin-top: auto;
            background-color: #ffffff;
            border-top: 1px solid #e9ecef;
        }
    </style>
</head>
<body>

    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= site_url('inicio') ?>">
                <i class="bi bi-mortarboard-fill fs-3 me-2"></i>
                <span>Sistema Disciplinario</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Navegación">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" href="<?= site_url('inicio') ?>">
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
                        <a class="nav-link fw-semibold" href="<?= site_url('usuarios') ?>">
                            <i class="bi bi-person-gear me-1"></i> Usuarios y Maestros
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>

                <!-- Datos de Usuario y Cerrar Sesión -->
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end text-white d-none d-md-block">
                        <div class="fw-semibold lh-1"><?= esc(session('nombre_completo') ?? session('nombres')) ?></div>
                        <span class="badge bg-light text-primary mt-1"><?= esc(session('rol_nombre')) ?></span>
                    </div>

                    <a href="<?= site_url('logout') ?>" class="btn btn-outline-light btn-sm px-3 fw-semibold" title="Cerrar Sesión">
                        <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="container py-4">

        <!-- Mensaje de bienvenida / Alertas -->
        <?php if (session()->getFlashdata('exito')): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                <div class="fw-semibold"><?= esc(session()->getFlashdata('exito')) ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>

        <!-- Banner de Bienvenida -->
        <div class="card shadow-sm border-0 mb-4 bg-white">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="h3 fw-bold text-dark mb-2">
                            ¡Bienvenido(a), <?= esc(session('nombres')) ?>!
                        </h1>
                        <p class="text-muted mb-3 fs-5">
                            Has accedido como <strong class="text-primary"><?= esc(session('rol_nombre')) ?></strong>. Desde este panel puedes gestionar estudiantes y generar los reportes disciplinarios.
                        </p>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-light text-dark border p-2">
                                <i class="bi bi-envelope-at me-1"></i> <?= esc(session('correo')) ?>
                            </span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle p-2">
                                <i class="bi bi-shield-check me-1"></i> Sesión activa
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                        <i class="bi bi-shield-check text-primary opacity-25" style="font-size: 7rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Módulos del Sistema -->
        <h2 class="h5 fw-bold text-secondary mb-3">Módulos del Sistema</h2>

        <div class="row g-4">
            <!-- Módulo Estudiantes -->
            <div class="col-md-6 col-lg-4">
                <div class="card card-menu shadow-sm h-100">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-primary-subtle text-primary me-3">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <h3 class="h5 fw-bold mb-0">Estudiantes</h3>
                                <small class="text-muted">Gestión de alumnos</small>
                            </div>
                        </div>
                        <p class="text-secondary small flex-grow-1">
                            Consulta la lista de alumnos, crea nuevos registros, actualiza datos y administra las bajas.
                        </p>
                        <a href="<?= site_url('estudiantes') ?>" class="btn btn-outline-primary btn-sm fw-semibold mt-2">
                            Ingresar a Estudiantes <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Módulo Reportes Disciplinarios -->
            <div class="col-md-6 col-lg-4">
                <div class="card card-menu shadow-sm h-100">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-danger-subtle text-danger me-3">
                                <i class="bi bi-journal-x"></i>
                            </div>
                            <div>
                                <h3 class="h5 fw-bold mb-0">Reportes Disciplinarios</h3>
                                <small class="text-muted">Crear y consultar faltas</small>
                            </div>
                        </div>
                        <p class="text-secondary small flex-grow-1">
                            Creación de reportes de conducta, registro de sanciones, seguimiento por docente y estado de resolución.
                        </p>
                        <a href="<?= site_url('reportes') ?>" class="btn btn-outline-danger btn-sm fw-semibold mt-2">
                            Ingresar a Reportes <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Módulo Grados y Secciones -->
            <div class="col-md-6 col-lg-4">
                <div class="card card-menu shadow-sm h-100">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-success-subtle text-success me-3">
                                <i class="bi bi-building"></i>
                            </div>
                            <div>
                                <h3 class="h5 fw-bold mb-0">Grados y Secciones</h3>
                                <small class="text-muted">Estructura académica</small>
                            </div>
                        </div>
                        <p class="text-secondary small flex-grow-1">
                            Administración de niveles escolares, habilitación de secciones y consulta de alumnos por grado.
                        </p>
                        <a href="<?= site_url('grados') ?>" class="btn btn-outline-success btn-sm fw-semibold mt-2">
                            Ingresar a Grados y Secciones <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <?php if (session()->get('rol_id') == 1): ?>
            <!-- Módulo Gestión de Usuarios y Maestros (Exclusivo Administrador) -->
            <div class="col-md-6 col-lg-4">
                <div class="card card-menu shadow-sm h-100">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-dark text-warning me-3">
                                <i class="bi bi-person-gear"></i>
                            </div>
                            <div>
                                <h3 class="h5 fw-bold mb-0">Usuarios y Maestros</h3>
                                <small class="text-muted">Control de accesos y docentes</small>
                            </div>
                        </div>
                        <p class="text-secondary small flex-grow-1">
                            Como Administrador puedes dar de alta nuevos maestros, asignarles grados a cargo y consultar los reportes que ingresan.
                        </p>
                        <a href="<?= site_url('usuarios') ?>" class="btn btn-outline-dark btn-sm fw-semibold mt-2">
                            Gestionar Maestros / Usuarios <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

    </main>

    <!-- Footer -->
    <footer class="py-3 text-center text-muted small">
        <div class="container">
            Sistema Disciplinario &copy; <?= date('Y') ?> - Todos los derechos reservados.
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
