<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Reporte Disciplinario - Sistema Disciplinario</title>

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
    </style>
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?= site_url('inicio') ?>">
                <i class="bi bi-mortarboard-fill me-2 fs-4"></i>
                <span>Sistema Disciplinario</span>
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="<?= site_url('reportes') ?>" class="btn btn-outline-light btn-sm fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Volver a Reportes
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <div class="card shadow border-0">
                    <div class="card-header bg-danger text-white p-4">
                        <h1 class="h4 mb-0 fw-bold">
                            <i class="bi bi-file-earmark-plus-fill me-2"></i>
                            Crear Nuevo Reporte Disciplinario
                        </h1>
                        <small class="text-white-50">Registra una incidencia de conducta o falta disciplinaria</small>
                    </div>

                    <div class="card-body p-4">

                        <!-- Errores de Validación -->
                        <?php if (session()->getFlashdata('errores')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Por favor verifique los siguientes campos:</div>
                                <ul class="mb-0 ps-3 small">
                                    <?php foreach (session()->getFlashdata('errores') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= site_url('reportes/guardar') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="row g-3">

                                <!-- Selección de Estudiante -->
                                <div class="col-md-6">
                                    <label for="estudiante_id" class="form-label fw-semibold">
                                        <i class="bi bi-person-fill text-danger me-1"></i> Estudiante Involucrado
                                    </label>
                                    <select class="form-select" id="estudiante_id" name="estudiante_id" required>
                                        <option value="" disabled <?= (old('estudiante_id') || $estudiante_preseleccionado) ? '' : 'selected' ?>>Selecciona un estudiante...</option>
                                        <?php foreach ($estudiantes as $est): ?>
                                            <?php
                                                $isSelected = (old('estudiante_id') == $est['estudiantes_id']) ||
                                                              (!old('estudiante_id') && $estudiante_preseleccionado == $est['estudiantes_id']);
                                            ?>
                                            <option value="<?= esc($est['estudiantes_id']) ?>" <?= $isSelected ? 'selected' : '' ?>>
                                                <?= esc($est['nombres']) ?> <?= esc($est['apellidos']) ?>
                                                <?php if (!empty($est['nombre_grado'])): ?>
                                                    (<?= esc($est['nombre_grado']) ?> - Sec. <?= esc($est['nombre_seccion']) ?>)
                                                <?php endif; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Selección de Docente -->
                                <div class="col-md-6">
                                    <label for="docente_id" class="form-label fw-semibold">
                                        <i class="bi bi-person-badge-fill text-primary me-1"></i> Docente que Reporta
                                    </label>
                                    <select class="form-select" id="docente_id" name="docente_id" required>
                                        <option value="" disabled <?= old('docente_id') ? '' : 'selected' ?>>Selecciona un docente...</option>
                                        <?php foreach ($docentes as $doc): ?>
                                            <option value="<?= esc($doc['docente_id']) ?>" <?= old('docente_id') == $doc['docente_id'] ? 'selected' : '' ?>>
                                                Prof(a). <?= esc($doc['nombre']) ?> <?= esc($doc['apellido']) ?> (<?= esc($doc['grado_encargado']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Tipo de Falta -->
                                <div class="col-md-6">
                                    <label for="tipo_falta_id" class="form-label fw-semibold">
                                        <i class="bi bi-exclamation-octagon-fill text-warning me-1"></i> Tipo de Falta
                                    </label>
                                    <select class="form-select" id="tipo_falta_id" name="tipo_falta_id" required>
                                        <option value="" disabled <?= old('tipo_falta_id') ? '' : 'selected' ?>>Selecciona el tipo de falta...</option>
                                        <?php foreach ($tipos_falta as $tf): ?>
                                            <option value="<?= esc($tf['tipo_falta_id']) ?>" <?= old('tipo_falta_id') == $tf['tipo_falta_id'] ? 'selected' : '' ?>>
                                                <?= esc($tf['nombre']) ?> [Gravedad: <?= esc($tf['gravedad']) ?>]
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Estado del Reporte -->
                                <div class="col-md-6">
                                    <label for="estado_id" class="form-label fw-semibold">
                                        <i class="bi bi-flag-fill text-info me-1"></i> Estado Inicial del Reporte
                                    </label>
                                    <select class="form-select" id="estado_id" name="estado_id" required>
                                        <?php foreach ($estados as $est): ?>
                                            <option value="<?= esc($est['estado_id']) ?>" <?= (old('estado_id', 1) == $est['estado_id']) ? 'selected' : '' ?>>
                                                <?= esc($est['nombre']) ?> - <?= esc($est['descripcion']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Fecha del incidente -->
                                <div class="col-md-6">
                                    <label for="fecha" class="form-label fw-semibold">
                                        <i class="bi bi-calendar3 me-1"></i> Fecha del Suceso
                                    </label>
                                    <input type="date"
                                           class="form-control"
                                           id="fecha"
                                           name="fecha"
                                           value="<?= esc(old('fecha', date('Y-m-d'))) ?>"
                                           required>
                                </div>

                                <!-- Hora del incidente -->
                                <div class="col-md-6">
                                    <label for="hora" class="form-label fw-semibold">
                                        <i class="bi bi-clock me-1"></i> Hora Aproximada
                                    </label>
                                    <input type="time"
                                           class="form-control"
                                           id="hora"
                                           name="hora"
                                           value="<?= esc(old('hora', date('H:i'))) ?>"
                                           required>
                                </div>

                                <!-- Motivo / Resumen breve -->
                                <div class="col-12">
                                    <label for="motivo" class="form-label fw-semibold">
                                        <i class="bi bi-card-text me-1"></i> Motivo del Reporte (Título breve)
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="motivo"
                                           name="motivo"
                                           placeholder="Ej. Incumplimiento reiterado de tareas / Agresión en el recreo"
                                           value="<?= esc(old('motivo')) ?>"
                                           required>
                                </div>

                                <!-- Descripción de la falta -->
                                <div class="col-12">
                                    <label for="descripcion_falta" class="form-label fw-semibold">
                                        <i class="bi bi-textarea-resize me-1"></i> Descripción Detallada de los Hechos
                                    </label>
                                    <textarea class="form-control"
                                              id="descripcion_falta"
                                              name="descripcion_falta"
                                              rows="4"
                                              placeholder="Escribe de manera clara y objetiva lo sucedido..."
                                              required><?= esc(old('descripcion_falta')) ?></textarea>
                                </div>

                                <!-- Acciones Tomadas -->
                                <div class="col-12">
                                    <label for="acciones_tomadas" class="form-label fw-semibold">
                                        <i class="bi bi-clipboard-check me-1"></i> Acciones Tomadas / Medidas Aplicadas (Opcional)
                                    </label>
                                    <textarea class="form-control"
                                              id="acciones_tomadas"
                                              name="acciones_tomadas"
                                              rows="3"
                                              placeholder="Ej. Se dialogó con el estudiante y se citó al encargado para el día de mañana..."><?= esc(old('acciones_tomadas')) ?></textarea>
                                </div>

                            </div>

                            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-danger px-4 fw-semibold shadow-sm">
                                    <i class="bi bi-save-fill me-1"></i> Guardar Reporte
                                </button>
                                <a href="<?= site_url('reportes') ?>" class="btn btn-secondary px-4">
                                    <i class="bi bi-arrow-left-circle me-1"></i> Cancelar
                                </a>
                            </div>

                        </form>
                    </div>

                    <div class="card-footer text-center text-muted small py-3">
                        Sistema Disciplinario Escolar &copy; <?= date('Y') ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
