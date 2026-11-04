<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema Disciplinario</title>

    <!-- Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons 1.11.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0d6efd 0%, #0a4292 50%, #031e42 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            padding: 20px 15px;
        }

        .login-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.25);
            background: #ffffff;
            width: 100%;
            max-width: 440px;
            overflow: hidden;
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-header {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            color: #ffffff;
            padding: 2.2rem 1.5rem;
            text-align: center;
        }

        .login-header .icon-circle {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 0.8rem;
        }

        .login-body {
            padding: 2rem;
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            color: #0d6efd;
        }

        .btn-login {
            padding: 0.75rem 1.25rem;
            font-size: 1.05rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(13, 110, 253, 0.3);
        }

        .credential-pill {
            cursor: pointer;
            font-size: 0.82rem;
            transition: background-color 0.2s;
        }

        .credential-pill:hover {
            background-color: #dee2e6 !important;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <!-- Header -->
        <div class="login-header">
            <div class="icon-circle">
                <i class="bi bi-shield-check"></i>
            </div>
            <h2 class="h4 fw-bold mb-1">Sistema Disciplinario</h2>
            <p class="mb-0 text-white-50 small">Control y Seguimiento Escolar</p>
        </div>

        <!-- Body -->
        <div class="login-body">
            <h3 class="h5 fw-semibold text-center text-secondary mb-4">Iniciar Sesión</h3>

            <!-- Alertas de Error -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                    <div><?= esc(session()->getFlashdata('error')) ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <!-- Alertas Informativas / Éxito -->
            <?php if (session()->getFlashdata('mensaje')): ?>
                <div class="alert alert-info alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-info-circle-fill fs-5 me-2"></i>
                    <div><?= esc(session()->getFlashdata('mensaje')) ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <!-- Errores de Validación -->
            <?php if (session()->getFlashdata('errores_validacion')): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <div class="fw-semibold mb-1"><i class="bi bi-exclamation-circle-fill me-1"></i> Por favor verifique:</div>
                    <ul class="mb-0 ps-3 small">
                        <?php foreach (session()->getFlashdata('errores_validacion') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <!-- Formulario de Inicio de Sesión -->
            <form action="<?= site_url('login') ?>" method="post" id="formLogin">
                <?= csrf_field() ?>

                <!-- Campo Correo Electrónico -->
                <div class="mb-3">
                    <label for="correo_electronico" class="form-label text-secondary fw-semibold small">
                        <i class="bi bi-envelope-at me-1"></i> Correo Electrónico
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-secondary"><i class="bi bi-person"></i></span>
                        <input type="email"
                               class="form-control"
                               id="correo_electronico"
                               name="correo_electronico"
                               placeholder="ejemplo@escuela.com"
                               value="<?= esc(old('correo_electronico')) ?>"
                               required
                               autofocus>
                    </div>
                </div>

                <!-- Campo Contraseña -->
                <div class="mb-4">
                    <label for="contrasena" class="form-label text-secondary fw-semibold small">
                        <i class="bi bi-lock me-1"></i> Contraseña
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-secondary"><i class="bi bi-key"></i></span>
                        <input type="password"
                               class="form-control"
                               id="contrasena"
                               name="contrasena"
                               placeholder="••••••••"
                               required>
                        <button class="btn btn-outline-secondary" type="button" id="btnTogglePassword" title="Mostrar/ocultar contraseña">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Botón de Envío -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Iniciar Sesión
                    </button>
                </div>
            </form>

            <!-- Acceso Rápido / Sugerencia de Cuentas para Pruebas -->
            <div class="mt-4 pt-3 border-top">
                <p class="text-muted small text-center mb-2 fw-semibold">
                    <i class="bi bi-shield-lock me-1"></i> Cuentas registradas (Pruebas)
                </p>
                <div class="d-flex flex-column gap-1">
                    <div class="p-2 bg-light rounded credential-pill d-flex justify-content-between align-items-center"
                         onclick="llenarCredenciales('brendavas20022332@gmail.com', '123456')">
                        <div>
                            <span class="badge bg-primary me-1">Admin</span>
                            <span class="text-dark">brendavas20022332@gmail.com</span>
                        </div>
                        <i class="bi bi-arrow-right-short text-secondary fs-5"></i>
                    </div>

                    <div class="p-2 bg-light rounded credential-pill d-flex justify-content-between align-items-center"
                         onclick="llenarCredenciales('danielsuhulsandoval@gmail.com', '123456')">
                        <div>
                            <span class="badge bg-success me-1">Docente</span>
                            <span class="text-dark">danielsuhulsandoval@gmail.com</span>
                        </div>
                        <i class="bi bi-arrow-right-short text-secondary fs-5"></i>
                    </div>
                </div>
                <div class="text-center text-muted small mt-2">
                    <i class="bi bi-info-circle"></i> Contraseña inicial: <code>123456</code> (o haz clic en una cuenta para autocompletar)
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script de Interactividad -->
    <script>
        // Alternar visualización de contraseña
        const btnTogglePassword = document.getElementById('btnTogglePassword');
        const inputContrasena = document.getElementById('contrasena');
        const toggleIcon = document.getElementById('toggleIcon');

        btnTogglePassword.addEventListener('click', function () {
            const isPassword = inputContrasena.getAttribute('type') === 'password';
            inputContrasena.setAttribute('type', isPassword ? 'text' : 'password');
            toggleIcon.classList.toggle('bi-eye', !isPassword);
            toggleIcon.classList.toggle('bi-eye-slash', isPassword);
        });

        // Autocompletar credenciales de prueba con un clic
        function llenarCredenciales(correo, contrasena) {
            document.getElementById('correo_electronico').value = correo;
            document.getElementById('contrasena').value = contrasena;
        }
    </script>
</body>
</html>
