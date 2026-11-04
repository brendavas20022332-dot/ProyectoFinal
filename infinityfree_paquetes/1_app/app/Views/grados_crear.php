<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Grado - Sistema Disciplinario</title>

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
                <a href="<?= site_url('grados') ?>" class="btn btn-outline-light btn-sm fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Volver a Grados
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                <div class="card shadow border-0">
                    <div class="card-header bg-success text-white p-4">
                        <h1 class="h4 mb-0 fw-bold">
                            <i class="bi bi-plus-circle-fill me-2"></i>
                            Crear Nuevo Grado
                        </h1>
                        <small class="text-white-50">Registra un nivel educativo y asigna sus secciones correspondientes</small>
                    </div>

                    <div class="card-body p-4">

                        <!-- Errores de Validación -->
                        <?php if (session()->getFlashdata('errores')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Por favor verifique:</div>
                                <ul class="mb-0 ps-3 small">
                                    <?php foreach (session()->getFlashdata('errores') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= site_url('grados/guardar') ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- Nombre del Grado -->
                            <div class="mb-3">
                                <label for="nombre_grado" class="form-label fw-semibold">
                                    <i class="bi bi-mortarboard me-1 text-success"></i> Nombre del Grado
                                </label>
                                <input type="text"
                                       class="form-control"
                                       id="nombre_grado"
                                       name="nombre_grado"
                                       placeholder="Ej. Primero Básico / Séptimo Grado / Prekinder"
                                       value="<?= esc(old('nombre_grado')) ?>"
                                       required
                                       autofocus>
                            </div>

                            <!-- Ciclo Lectivo -->
                            <div class="mb-3">
                                <label for="ciclo_lectivo" class="form-label fw-semibold">
                                    <i class="bi bi-calendar-check me-1 text-primary"></i> Ciclo Lectivo
                                </label>
                                <input type="number"
                                       class="form-control"
                                       id="ciclo_lectivo"
                                       name="ciclo_lectivo"
                                       value="<?= esc(old('ciclo_lectivo', date('Y'))) ?>"
                                       min="2020"
                                       max="2035"
                                       required>
                            </div>

                            <!-- Secciones a Habilitar -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold d-block">
                                    <i class="bi bi-grid-fill me-1 text-info"></i> Secciones Habilitadas para este Grado
                                </label>
                                <div class="row g-2 p-3 bg-light rounded border">
                                    <?php foreach ($secciones as $sec): ?>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="secciones[]"
                                                       value="<?= esc($sec['seccion_id']) ?>"
                                                       id="sec<?= esc($sec['seccion_id']) ?>"
                                                       <?= ($sec['nombre_seccion'] === 'C' || (is_array(old('secciones')) && in_array($sec['seccion_id'], old('secciones')))) ? 'checked' : '' ?>>
                                                <label class="form-check-label fw-medium" for="sec<?= esc($sec['seccion_id']) ?>">
                                                    Sección <?= esc($sec['nombre_seccion']) ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <small class="text-muted">Selecciona las secciones que estarán disponibles para inscribir alumnos.</small>
                            </div>

                            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-success px-4 fw-semibold shadow-sm">
                                    <i class="bi bi-save-fill me-1"></i> Guardar Grado
                                </button>
                                <a href="<?= site_url('grados') ?>" class="btn btn-secondary px-4">
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
