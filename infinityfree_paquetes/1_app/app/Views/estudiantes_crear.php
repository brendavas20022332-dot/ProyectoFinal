<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Estudiante - Sistema Disciplinario</title>

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
                <a href="<?= site_url('estudiantes') ?>" class="btn btn-outline-light btn-sm fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Volver a Lista
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white p-4">
                        <h1 class="h4 mb-0 fw-bold">
                            <i class="bi bi-person-plus-fill me-2"></i>
                            Registrar Nuevo Estudiante
                        </h1>
                        <small class="text-white-50">Completa los campos para ingresar al alumno al sistema</small>
                    </div>

                    <div class="card-body p-4">

                        <!-- Errores de Validación -->
                        <?php if (session()->getFlashdata('errores')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Hubo errores en el formulario:</div>
                                <ul class="mb-0 ps-3 small">
                                    <?php foreach (session()->getFlashdata('errores') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= site_url('estudiantes/guardar') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="row g-3">
                                <!-- Nombres -->
                                <div class="col-md-6">
                                    <label for="nombres" class="form-label fw-semibold">
                                        <i class="bi bi-person me-1"></i> Nombres
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="nombres"
                                           name="nombres"
                                           placeholder="Ej. Carlos Eduardo"
                                           value="<?= esc(old('nombres')) ?>"
                                           required>
                                </div>

                                <!-- Apellidos -->
                                <div class="col-md-6">
                                    <label for="apellidos" class="form-label fw-semibold">
                                        <i class="bi bi-person me-1"></i> Apellidos
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="apellidos"
                                           name="apellidos"
                                           placeholder="Ej. López García"
                                           value="<?= esc(old('apellidos')) ?>"
                                           required>
                                </div>

                                <!-- Fecha de Nacimiento -->
                                <div class="col-md-6">
                                    <label for="fecha_nacimiento" class="form-label fw-semibold">
                                        <i class="bi bi-calendar-event me-1"></i> Fecha de Nacimiento
                                    </label>
                                    <input type="date"
                                           class="form-control"
                                           id="fecha_nacimiento"
                                           name="fecha_nacimiento"
                                           value="<?= esc(old('fecha_nacimiento')) ?>"
                                           required>
                                </div>

                                <!-- Género -->
                                <div class="col-md-6">
                                    <label for="genero" class="form-label fw-semibold">
                                        <i class="bi bi-gender-ambiguous me-1"></i> Género
                                    </label>
                                    <select class="form-select" id="genero" name="genero" required>
                                        <option value="" disabled <?= old('genero') ? '' : 'selected' ?>>Selecciona el género...</option>
                                        <option value="Masculino" <?= old('genero') === 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                                        <option value="Femenino" <?= old('genero') === 'Femenino' ? 'selected' : '' ?>>Femenino</option>
                                    </select>
                                </div>

                                <!-- Grado y Sección -->
                                <div class="col-md-6">
                                    <label for="grado_seccion_id" class="form-label fw-semibold">
                                        <i class="bi bi-mortarboard me-1"></i> Grado y Sección
                                    </label>
                                    <select class="form-select" id="grado_seccion_id" name="grado_seccion_id" required>
                                        <option value="" disabled <?= (old('grado_seccion_id') || !empty($grado_id_preseleccionado) || !empty($grado_seccion_preseleccionado)) ? '' : 'selected' ?>>Selecciona un grado...</option>
                                        <?php 
                                            $preseleccionAplicada = false;
                                            foreach ($grados_secciones as $gs): 
                                                $isSelected = false;
                                                if (old('grado_seccion_id') == $gs['grado_seccion_id']) {
                                                    $isSelected = true;
                                                } elseif (!old('grado_seccion_id') && !$preseleccionAplicada) {
                                                    if (!empty($grado_seccion_preseleccionado) && $grado_seccion_preseleccionado == $gs['grado_seccion_id']) {
                                                        $isSelected = true;
                                                        $preseleccionAplicada = true;
                                                    } elseif (!empty($grado_id_preseleccionado) && $grado_id_preseleccionado == $gs['grado_id']) {
                                                        $isSelected = true;
                                                        $preseleccionAplicada = true;
                                                    }
                                                }
                                        ?>
                                            <option value="<?= esc($gs['grado_seccion_id']) ?>" <?= $isSelected ? 'selected' : '' ?>>
                                                <?= esc($gs['nombre_grado']) ?> - Sección <?= esc($gs['nombre_seccion']) ?> (Ciclo <?= esc($gs['ciclo_lectivo']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Encargado -->
                                <div class="col-md-6">
                                    <label for="encargado_id" class="form-label fw-semibold">
                                        <i class="bi bi-people me-1"></i> Encargado / Tutor
                                    </label>
                                    <select class="form-select" id="encargado_id" name="encargado_id" required>
                                        <option value="" disabled <?= old('encargado_id') ? '' : 'selected' ?>>Selecciona un encargado...</option>
                                        <?php foreach ($encargados as $enc): ?>
                                            <option value="<?= esc($enc['encargado_id']) ?>" <?= old('encargado_id') == $enc['encargado_id'] ? 'selected' : '' ?>>
                                                <?= esc($enc['nombre']) ?> <?= esc($enc['apellido']) ?> (<?= esc($enc['parentesco']) ?>) - Tel: <?= esc($enc['telefono']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-success px-4 fw-semibold">
                                    <i class="bi bi-save-fill me-1"></i> Guardar Estudiante
                                </button>
                                <a href="<?= site_url('estudiantes') ?>" class="btn btn-secondary px-4">
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
