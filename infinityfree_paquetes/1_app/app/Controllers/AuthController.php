<?php

namespace App\Controllers;

use App\Models\UsuariosModel;

class AuthController extends BaseController
{
    /**
     * Muestra la vista de inicio de sesión
     */
    public function login()
    {
        // Si ya está autenticado, redirigir al panel principal
        if (session()->get('isLoggedIn')) {
            return redirect()->to(site_url('inicio'));
        }

        return view('auth/login');
    }

    /**
     * Procesa la autenticación del usuario
     */
    public function autenticar()
    {
        $reglas = [
            'correo_electronico' => [
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'El correo electrónico es obligatorio.',
                    'valid_email' => 'Por favor ingrese un correo electrónico válido.'
                ]
            ],
            'contrasena' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'La contraseña es obligatoria.'
                ]
            ]
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()
                ->withInput()
                ->with('errores_validacion', $this->validator->getErrors());
        }

        $correo = trim($this->request->getPost('correo_electronico'));
        $contrasena = (string) $this->request->getPost('contrasena');

        $usuariosModel = new UsuariosModel();
        $usuario = $usuariosModel->obtenerPorCorreo($correo);

        if (!$usuario) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'El correo electrónico no se encuentra registrado en el sistema.');
        }

        if (isset($usuario['estado']) && $usuario['estado'] !== 'Activo') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Esta cuenta se encuentra inactiva. Comuníquese con la administración.');
        }

        // Verificar contraseña (mediante hash o coincidencia directa de respaldo)
        $passwordValida = password_verify($contrasena, $usuario['contrasena']) || ($usuario['contrasena'] === $contrasena);

        if (!$passwordValida) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'La contraseña ingresada es incorrecta.');
        }

        // Guardar información en la sesión
        $datosSesion = [
            'usuario_id'      => $usuario['usuarios_id'],
            'nombres'         => $usuario['nombres'],
            'apellidos'       => $usuario['apellidos'],
            'nombre_completo' => $usuario['nombres'] . ' ' . $usuario['apellidos'],
            'correo'          => $usuario['correo_electronico'],
            'rol_id'          => $usuario['rol_id'],
            'rol_nombre'      => $usuario['rol_nombre'] ?? 'Usuario',
            'isLoggedIn'      => true,
        ];

        session()->set($datosSesion);

        return redirect()->to(site_url('inicio'))
            ->with('exito', '¡Bienvenido(a), ' . esc($usuario['nombres']) . '!');
    }

    /**
     * Cierra la sesión activa
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('login'))
            ->with('mensaje', 'Has cerrado sesión correctamente.');
    }
}
