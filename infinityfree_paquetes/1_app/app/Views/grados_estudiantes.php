<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estudiantes de <?= esc($grado['nombre_grado']) ?> - Sistema Disciplinario</title>

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
                </ul>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="<?= site_url('grados') ?>" class="btn btn-outline-light btn-sm fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Volver a Grados
                </a>
                <a href="<?= site_url('logout') ?>" class="btn btn-outline-light btn-sm fw-semibold">
                    <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-2">

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white p-3 p-md-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h1 class="h4 mb-0 fw-bold">
                        <i class="bi bi-mortarboard-fill me-2"></i>
                        Estudiantes en: <?= esc($grado['nombre_grado']) ?>
                    </h1>
                    <small class="text-white-50">Listado de alumnos inscritos en este grado académico</small>
                </div>

                <div class="d-flex gap-2">
                    <!-- Botón para ingresar estudiante directamente a este grado -->
                    <a href="<?= site_url('estudiantes/crear?grado_id=' . $grado['grado_id']) ?>" class="btn btn-success fw-bold shadow-sm">
                        <i class="bi bi-person-plus-fill me-1"></i>
                        Ingresar Estudiante a este Grado
                    </a>
                    <a href="<?= site_url('grados') ?>" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left me-1"></i> Volver
                    </a>
                </div>
            </div>

            <div class="card-body p-3 p-md-4">

                <!-- Resumen de secciones habilitadas para este grado -->
                <div class="p-3 bg-light rounded border mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <span class="text-muted small d-block">Secciones disponibles:</span>
                        <div class="d-flex gap-1 mt-1">
                            <?php if (!empty($grados_secciones)): ?>
                                <?php foreach ($grados_secciones as $gs): ?>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        Sección <?= esc($gs['nombre_seccion']) ?> (Ciclo <?= esc($gs['ciclo_lectivo']) ?>)
                                    </span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="badge bg-secondary">Sin secciones configuradas</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <span class="badge bg-dark px-3 py-2 fs-6">
                            Total inscritos: <?= count($estudiantes) ?> estudiante(s)
                        </span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle table-bordered">
                        <thead class="table-dark table-custom">
                            <tr>
                                <th class="text-center" style="width: 50px;">ID</th>
                                <th>Estudiante</th>
                                <th>Sección Asignada</th>
                                <th>Género</th>
                                <th>Fecha de Nacimiento</th>
                                <th>Encargado / Contacto</th>
                                <th class="text-center" style="width: 180px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($estudiantes)): ?>
                                <?php foreach ($estudiantes as $est): ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted"><?= esc($est['estudiantes_id']) ?></td>
                                    <td>
                                        <div class="fw-bold text-dark">
                                            <?= esc($est['nombres']) ?> <?= esc($est['apellidos']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">
                                            Sección <?= esc($est['nombre_seccion']) ?>
                                        </span>
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
                                        <i class="bi bi-calendar3 me-1 text-muted"></i>
                                        <?= esc(date('d/m/Y', strtotime($est['fecha_nacimiento']))) ?>
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
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="<?= site_url('reportes/crear?estudiante_id=' . $est['estudiantes_id']) ?>"
                                               class="btn btn-outline-danger btn-sm"
                                               title="Reportar estudiante">
                                                <i class="bi bi-journal-plus"></i>
                                                Reportar
                                            </a>
                                            <a href="<?= site_url('estudiantes/editar/' . $est['estudiantes_id']) ?>"
                                               class="btn btn-warning btn-sm"
                                               title="Editar estudiante">
                                                <i class="bi bi-pencil-square"></i>
                                                Editar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-people fs-1 d-block mb-2 text-secondary"></i>
                                        Aún no hay estudiantes inscritos en <?= esc($grado['nombre_grado']) ?>.
                                        <div class="mt-3">
                                            <a href="<?= site_url('estudiantes/crear?grado_id=' . $grado['grado_id']) ?>" class="btn btn-success btn-sm fw-semibold">
                                                <i class="bi bi-person-plus-fill me-1"></i>
                                                Ingresar el primer estudiante a este grado
                                            </a>
                                        </div>
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
