<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Usuario o Maestro - Sistema Disciplinario</title>

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
                <a href="<?= site_url('usuarios') ?>" class="btn btn-outline-light btn-sm fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Volver a Usuarios
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow border-0">
                    <div class="card-header bg-warning text-dark p-4">
                        <h1 class="h4 mb-0 fw-bold">
                            <i class="bi bi-pencil-square me-2"></i>
                            Editar Usuario: <?= esc($usuario['nombres']) ?> <?= esc($usuario['apellidos']) ?>
                        </h1>
                        <small class="text-muted">Modifica los datos personales, rol o grado asignado</small>
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

                        <form action="<?= site_url('usuarios/actualizar/' . $usuario['usuarios_id']) ?>" method="post">
                            <?= csrf_field() ?>

                            <!-- ID de docente si ya existe -->
                            <?php if (!empty($usuario['docente_id'])): ?>
                                <input type="hidden" name="docente_id" value="<?= esc($usuario['docente_id']) ?>">
                            <?php endif; ?>

                            <div class="row g-3">

                                <!-- Nombres -->
                                <div class="col-md-6">
                                    <label for="nombres" class="form-label fw-semibold">
                                        <i class="bi bi-person me-1 text-primary"></i> Nombres
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="nombres"
                                           name="nombres"
                                           value="<?= esc(old('nombres', $usuario['nombres'])) ?>"
                                           required>
                                </div>

                                <!-- Apellidos -->
                                <div class="col-md-6">
                                    <label for="apellidos" class="form-label fw-semibold">
                                        <i class="bi bi-person me-1 text-primary"></i> Apellidos
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="apellidos"
                                           name="apellidos"
                                           value="<?= esc(old('apellidos', $usuario['apellidos'])) ?>"
                                           required>
                                </div>

                                <!-- Correo Electrónico -->
                                <div class="col-md-6">
                                    <label for="correo_electronico" class="form-label fw-semibold">
                                        <i class="bi bi-envelope-at me-1 text-primary"></i> Correo Electrónico
                                    </label>
                                    <input type="email"
                                           class="form-control"
                                           id="correo_electronico"
                                           name="correo_electronico"
                                           value="<?= esc(old('correo_electronico', $usuario['correo_electronico'])) ?>"
                                           required>
                                </div>

                                <!-- Teléfono -->
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label fw-semibold">
                                        <i class="bi bi-telephone me-1 text-success"></i> Teléfono
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="telefono"
                                           name="telefono"
                                           value="<?= esc(old('telefono', $usuario['telefono'])) ?>">
                                </div>

                                <!-- Contraseña (Opcional en edición) -->
                                <div class="col-md-6">
                                    <label for="contrasena" class="form-label fw-semibold">
                                        <i class="bi bi-key me-1 text-warning"></i> Nueva Contraseña (Opcional)
                                    </label>
                                    <div class="input-group">
                                        <input type="password"
                                               class="form-control"
                                               id="contrasena"
                                               name="contrasena"
                                               placeholder="Dejar en blanco para no cambiarla">
                                        <button class="btn btn-outline-secondary" type="button" id="btnTogglePass">
                                            <i class="bi bi-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Solo escribe aquí si deseas cambiar su contraseña actual.</small>
                                </div>

                                <!-- Rol del Sistema -->
                                <div class="col-md-6">
                                    <label for="rol_id" class="form-label fw-semibold">
                                        <i class="bi bi-shield-check me-1 text-danger"></i> Rol del Sistema
                                    </label>
                                    <?php $rolActual = old('rol_id', $usuario['rol_id']); ?>
                                    <select class="form-select" id="rol_id" name="rol_id" required>
                                        <?php foreach ($roles as $rol): ?>
                                            <option value="<?= esc($rol['rol_id']) ?>" <?= $rolActual == $rol['rol_id'] ? 'selected' : '' ?>>
                                                <?= esc($rol['nombre']) ?> (<?= esc($rol['descripcion']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- SECCIÓN ESPECÍFICA PARA DOCENTES: GRADO A CARGO -->
                                <div class="col-12" id="seccionDocente">
                                    <div class="p-3 bg-primary-subtle rounded border border-primary-subtle">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-person-video3 fs-4 text-primary me-2"></i>
                                            <strong class="text-primary">Configuración de Maestro / Docente</strong>
                                        </div>

                                        <div class="row g-2 align-items-center">
                                            <div class="col-md-6">
                                                <label for="grado_encargado_select" class="form-label fw-semibold small">
                                                    Seleccionar Grado Disponible:
                                                </label>
                                                <select class="form-select" id="grado_encargado_select" onchange="actualizarGradoEncargado(this.value)">
                                                    <option value="">Selecciona para autocompletar...</option>
                                                    <?php foreach ($grados as $g): ?>
                                                        <option value="<?= esc($g['nombre_grado']) ?>" <?= ($usuario['grado_encargado'] ?? '') === $g['nombre_grado'] ? 'selected' : '' ?>>
                                                            <?= esc($g['nombre_grado']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                    <option value="Docente de Área / Especialidad">Docente de Área / Especialidad</option>
                                                    <option value="Docente General">Docente General</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="grado_encargado" class="form-label fw-semibold small">
                                                    Asignación o Grado Encargado:
                                                </label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="grado_encargado"
                                                       name="grado_encargado"
                                                       value="<?= esc(old('grado_encargado', $usuario['grado_encargado'] ?? '')) ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Estado -->
                                <div class="col-md-6">
                                    <label for="estado" class="form-label fw-semibold">
                                        <i class="bi bi-toggle-on me-1 text-success"></i> Estado de la Cuenta
                                    </label>
                                    <?php $estActual = old('estado', $usuario['estado']); ?>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="Activo" <?= $estActual === 'Activo' ? 'selected' : '' ?>>Activo (Acceso habilitado)</option>
                                        <option value="Inactivo" <?= $estActual === 'Inactivo' ? 'selected' : '' ?>>Inactivo (Acceso suspendido)</option>
                                    </select>
                                </div>

                            </div>

                            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-warning px-4 fw-semibold shadow-sm">
                                    <i class="bi bi-save-fill me-1"></i> Actualizar Usuario
                                </button>
                                <a href="<?= site_url('usuarios') ?>" class="btn btn-secondary px-4">
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

    <!-- Script Interactivo -->
    <script>
        const selectRol = document.getElementById('rol_id');
        const seccionDocente = document.getElementById('seccionDocente');
        const btnTogglePass = document.getElementById('btnTogglePass');
        const inputPass = document.getElementById('contrasena');
        const toggleIcon = document.getElementById('toggleIcon');

        function verificarRol() {
            if (selectRol.value === '2') {
                seccionDocente.style.display = 'block';
            } else {
                seccionDocente.style.display = 'none';
            }
        }

        function actualizarGradoEncargado(valor) {
            if (valor) {
                document.getElementById('grado_encargado').value = valor;
            }
        }

        selectRol.addEventListener('change', verificarRol);
        verificarRol();

        btnTogglePass.addEventListener('click', function () {
            const esPassword = inputPass.getAttribute('type') === 'password';
            inputPass.setAttribute('type', esPassword ? 'text' : 'password');
            toggleIcon.classList.toggle('bi-eye', !esPassword);
            toggleIcon.classList.toggle('bi-eye-slash', esPassword);
        });
    </script>
</body>
</html>
