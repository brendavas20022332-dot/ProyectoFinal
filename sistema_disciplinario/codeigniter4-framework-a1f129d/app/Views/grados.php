<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grados y Secciones - Sistema Disciplinario</title>

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
                        <a class="nav-link active fw-semibold" href="<?= site_url('grados') ?>">
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
            <div class="card-header bg-success text-white p-3 p-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h1 class="h4 mb-0 fw-bold">
                        <i class="bi bi-building me-2"></i>
                        Administración de Grados y Secciones
                    </h1>
                    <small class="text-white-50">Gestiona la oferta académica e inscribe a los alumnos en sus respectivos grados</small>
                </div>

                <a href="<?= site_url('grados/crear') ?>" class="btn btn-light text-success fw-bold shadow-sm">
                    <i class="bi bi-plus-circle-fill me-1"></i>
                    Crear Nuevo Grado
                </a>
            </div>

            <div class="card-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small">
                        Total de grados registrados: <strong><?= count($grados) ?></strong>
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle table-bordered">
                        <thead class="table-dark table-custom">
                            <tr>
                                <th class="text-center" style="width: 60px;">ID</th>
                                <th>Nombre del Grado</th>
                                <th>Secciones Habilitadas</th>
                                <th class="text-center">Alumnos Inscritos</th>
                                <th class="text-center" style="width: 320px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($grados)): ?>
                                <?php foreach ($grados as $g): ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= esc($g['grado_id']) ?></td>
                                    <td>
                                        <div class="fw-bold text-dark fs-6">
                                            <i class="bi bi-mortarboard text-success me-1"></i>
                                            <?= esc($g['nombre_grado']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (!empty($g['secciones'])): ?>
                                            <div class="d-flex flex-wrap gap-1">
                                                <?php foreach ($g['secciones'] as $sec): ?>
                                                    <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">
                                                        Sec. <?= esc($sec['nombre_seccion']) ?> (<?= esc($sec['ciclo_lectivo']) ?>)
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Sin secciones</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill bg-light text-dark border px-3 py-2 fs-6">
                                            <i class="bi bi-people-fill text-primary me-1"></i>
                                            <?= esc($g['total_estudiantes']) ?> estudiante(s)
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Ver / Ingresar estudiantes a este grado -->
                                            <a href="<?= site_url('grados/estudiantes/' . $g['grado_id']) ?>"
                                               class="btn btn-primary btn-sm fw-semibold"
                                               title="Ver alumnos de este grado e ingresar nuevos">
                                                <i class="bi bi-people me-1"></i>
                                                Alumnos (<?= esc($g['total_estudiantes']) ?>)
                                            </a>

                                            <!-- Editar Grado -->
                                            <a href="<?= site_url('grados/editar/' . $g['grado_id']) ?>"
                                               class="btn btn-warning btn-sm"
                                               title="Editar nombre y secciones">
                                                <i class="bi bi-pencil-square"></i>
                                                Editar
                                            </a>

                                            <!-- Eliminar Grado -->
                                            <form action="<?= site_url('grados/eliminar/' . $g['grado_id']) ?>"
                                                  method="post"
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Estás seguro de que deseas eliminar el grado <?= esc($g['nombre_grado']) ?>?');">
                                                <?= csrf_field() ?>
                                                <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        title="Eliminar grado">
                                                    <i class="bi bi-trash-fill"></i>
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-building fs-1 d-block mb-2"></i>
                                        No hay grados registrados actualmente.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
