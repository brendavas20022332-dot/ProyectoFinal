<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Usuario o Maestro - Sistema Disciplinario</title>

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
                    <div class="card-header bg-dark text-white p-4">
                        <h1 class="h4 mb-0 fw-bold">
                            <i class="bi bi-person-plus-fill me-2 text-warning"></i>
                            Registrar Nuevo Maestro o Usuario
                        </h1>
                        <small class="text-white-50">Completa el formulario para dar de alta al maestro y otorgarle acceso al sistema</small>
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

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                <?= esc(session()->getFlashdata('error')) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= site_url('usuarios/guardar') ?>" method="post">
                            <?= csrf_field() ?>

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
                                           placeholder="Ej. Laura Sofía"
                                           value="<?= esc(old('nombres')) ?>"
                                           required
                                           autofocus>
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
                                           placeholder="Ej. Hernández Mendoza"
                                           value="<?= esc(old('apellidos')) ?>"
                                           required>
                                </div>

                                <!-- Correo Electrónico -->
                                <div class="col-md-6">
                                    <label for="correo_electronico" class="form-label fw-semibold">
                                        <i class="bi bi-envelope-at me-1 text-primary"></i> Correo Electrónico (Acceso)
                                    </label>
                                    <input type="email"
                                           class="form-control"
                                           id="correo_electronico"
                                           name="correo_electronico"
                                           placeholder="ejemplo@escuela.com"
                                           value="<?= esc(old('correo_electronico')) ?>"
                                           required>
                                    <small class="text-muted">Será utilizado para iniciar sesión en la plataforma.</small>
                                </div>

                                <!-- Teléfono -->
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label fw-semibold">
                                        <i class="bi bi-telephone me-1 text-success"></i> Teléfono (Opcional)
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           id="telefono"
                                           name="telefono"
                                           placeholder="Ej. 55551234"
                                           value="<?= esc(old('telefono')) ?>">
                                </div>

                                <!-- Contraseña -->
                                <div class="col-md-6">
                                    <label for="contrasena" class="form-label fw-semibold">
                                        <i class="bi bi-key me-1 text-warning"></i> Contraseña Inicial
                                    </label>
                                    <div class="input-group">
                                        <input type="password"
                                               class="form-control"
                                               id="contrasena"
                                               name="contrasena"
                                               placeholder="Mínimo 6 caracteres"
                                               required>
                                        <button class="btn btn-outline-secondary" type="button" id="btnTogglePass">
                                            <i class="bi bi-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Recomendada: <code>123456</code> o la que definas.</small>
                                </div>

                                <!-- Rol del Sistema -->
                                <div class="col-md-6">
                                    <label for="rol_id" class="form-label fw-semibold">
                                        <i class="bi bi-shield-check me-1 text-danger"></i> Rol del Sistema
                                    </label>
                                    <select class="form-select" id="rol_id" name="rol_id" required>
                                        <?php foreach ($roles as $rol): ?>
                                            <?php
                                                // Preseleccionar 'Docente' (rol_id 2) por defecto si no hay old
                                                $selected = old('rol_id') ? (old('rol_id') == $rol['rol_id']) : ($rol['rol_id'] == 2);
                                            ?>
                                            <option value="<?= esc($rol['rol_id']) ?>" <?= $selected ? 'selected' : '' ?>>
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
                                        <p class="small text-secondary mb-3">
                                            Este maestro quedará habilitado de inmediato para reportar faltas disciplinarias y gestionar estudiantes.
                                        </p>

                                        <div class="row g-2 align-items-center">
                                            <div class="col-md-7">
                                                <label for="grado_encargado_select" class="form-label fw-semibold small">
                                                    Grado o Nivel a Cargo:
                                                </label>
                                                <select class="form-select" id="grado_encargado_select" onchange="actualizarGradoEncargado(this.value)">
                                                    <option value="">Selecciona o escribe el grado...</option>
                                                    <?php foreach ($grados as $g): ?>
                                                        <option value="<?= esc($g['nombre_grado']) ?>">
                                                            <?= esc($g['nombre_grado']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                    <option value="Docente de Área / Especialidad">Docente de Área / Especialidad</option>
                                                    <option value="Docente General">Docente General</option>
                                                </select>
                                            </div>

                                            <div class="col-md-5">
                                                <label for="grado_encargado" class="form-label fw-semibold small">
                                                    Asignación exacta:
                                                </label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="grado_encargado"
                                                       name="grado_encargado"
                                                       placeholder="Ej. Tercero Primaria"
                                                       value="<?= esc(old('grado_encargado', 'Tercero Primaria')) ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Estado -->
                                <div class="col-md-6">
                                    <label for="estado" class="form-label fw-semibold">
                                        <i class="bi bi-toggle-on me-1 text-success"></i> Estado de la Cuenta
                                    </label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="Activo" <?= old('estado') !== 'Inactivo' ? 'selected' : '' ?>>Activo (Puede ingresar al sistema)</option>
                                        <option value="Inactivo" <?= old('estado') === 'Inactivo' ? 'selected' : '' ?>>Inactivo (Acceso suspendido)</option>
                                    </select>
                                </div>

                            </div>

                            <div class="d-flex gap-2 mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                                    <i class="bi bi-save-fill me-1"></i> Guardar y Crear Acceso
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
            // rol_id == 2 es Docente
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
