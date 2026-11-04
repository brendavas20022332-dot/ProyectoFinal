<?php

namespace App\Controllers;

use App\Models\UsuariosModel;
use Config\Database;

class UsuariosControllers extends BaseController
{
    /**
     * Verifica que el usuario autenticado sea Administrador
     */
    private function verificarAdministrador()
    {
        if (session()->get('rol_id') != 1) {
            return redirect()->to(site_url('inicio'))
                ->with('error', 'Acceso denegado: Solo el Administrador tiene autorización para gestionar usuarios.');
        }
        return null;
    }

    /**
     * Muestra la lista de todos los usuarios
     */
    public function index()
    {
        if ($redirect = $this->verificarAdministrador()) {
            return $redirect;
        }

        $modelo = new UsuariosModel();
        $datos['usuarios'] = $modelo->obtenerUsuariosConDetalle();

        return view('usuarios', $datos);
    }

    /**
     * Muestra el formulario para crear un nuevo usuario
     */
    public function crear()
    {
        if ($redirect = $this->verificarAdministrador()) {
            return $redirect;
        }

        $db = Database::connect();

        // Obtener roles disponibles
        $datos['roles'] = $db->table('roles')->get()->getResultArray();

        // Obtener lista de grados para asignar a docentes
        $datos['grados'] = $db->table('grados')->orderBy('grado_id', 'ASC')->get()->getResultArray();

        // Obtener lista de docentes existentes
        $datos['docentes_existentes'] = $db->table('docentes')->orderBy('nombre', 'ASC')->get()->getResultArray();

        return view('usuarios_crear', $datos);
    }

    /**
     * Guarda el nuevo usuario en la base de datos
     */
    public function guardar()
    {
        if ($redirect = $this->verificarAdministrador()) {
            return $redirect;
        }

        $reglas = [
            'nombres'            => 'required|min_length[2]|max_length[100]',
            'apellidos'          => 'required|min_length[2]|max_length[100]',
            'correo_electronico' => 'required|valid_email|is_unique[usuarios.correo_electronico]',
            'telefono'           => 'permit_empty|max_length[20]',
            'contrasena'         => 'required|min_length[6]',
            'rol_id'             => 'required|is_natural_no_zero',
            'estado'             => 'required|in_list[Activo,Inactivo]'
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()
                ->withInput()
                ->with('errores', $this->validator->getErrors());
        }

        $nombres = trim($this->request->getPost('nombres'));
        $apellidos = trim($this->request->getPost('apellidos'));
        $correo = trim($this->request->getPost('correo_electronico'));
        $telefono = trim($this->request->getPost('telefono'));
        $contrasena = (string) $this->request->getPost('contrasena');
        $rolId = (int) $this->request->getPost('rol_id');
        $estado = $this->request->getPost('estado');
        $gradoEncargado = trim($this->request->getPost('grado_encargado'));

        // Cifrar la contraseña
        $passwordHash = password_hash($contrasena, PASSWORD_BCRYPT);

        $db = Database::connect();
        $db->transStart();

        // 1. Insertar usuario
        $modelo = new UsuariosModel();
        $usuarioId = $modelo->insert([
            'rol_id'             => $rolId,
            'nombres'            => $nombres,
            'apellidos'          => $apellidos,
            'correo_electronico' => $correo,
            'telefono'           => $telefono ?: null,
            'contrasena'         => $passwordHash,
            'estado'             => $estado
        ]);

        // 2. Insertar en tabla de contraseñas
        $db->table('contrasenas')->insert([
            'usuario_id'      => $usuarioId,
            'contrasena_hash' => $passwordHash
        ]);

        // 3. Si el rol es Docente (rol_id == 2), sincronizar con la tabla docentes
        if ($rolId === 2) {
            $docenteExistente = $db->table('docentes')
                ->where('nombre', $nombres)
                ->where('apellido', $apellidos)
                ->get()
                ->getRowArray();

            if ($docenteExistente) {
                // Actualizar su grado encargado si se especificó
                if (!empty($gradoEncargado)) {
                    $db->table('docentes')
                        ->where('docente_id', $docenteExistente['docente_id'])
                        ->update(['grado_encargado' => $gradoEncargado]);
                }
            } else {
                // Crear el registro del docente para reportes disciplinarios
                $db->table('docentes')->insert([
                    'nombre'          => $nombres,
                    'apellido'        => $apellidos,
                    'grado_encargado' => $gradoEncargado ?: 'Sin asignar'
                ]);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al registrar el usuario en el sistema.');
        }

        return redirect()->to(site_url('usuarios'))
            ->with('exito', 'Usuario "' . esc($nombres) . ' ' . esc($apellidos) . '" creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un usuario
     */
    public function editar($id)
    {
        if ($redirect = $this->verificarAdministrador()) {
            return $redirect;
        }

        $modelo = new UsuariosModel();
        $usuario = $modelo->obtenerUsuarioPorId($id);

        if (!$usuario) {
            return redirect()->to(site_url('usuarios'))
                ->with('error', 'El usuario no existe.');
        }

        $db = Database::connect();
        $datos['usuario'] = $usuario;
        $datos['roles'] = $db->table('roles')->get()->getResultArray();
        $datos['grados'] = $db->table('grados')->orderBy('grado_id', 'ASC')->get()->getResultArray();

        return view('usuarios_editar', $datos);
    }

    /**
     * Actualiza los datos de un usuario
     */
    public function actualizar($id)
    {
        if ($redirect = $this->verificarAdministrador()) {
            return $redirect;
        }

        $modelo = new UsuariosModel();
        $usuario = $modelo->find($id);

        if (!$usuario) {
            return redirect()->to(site_url('usuarios'))
                ->with('error', 'El usuario no existe.');
        }

        $reglas = [
            'nombres'            => 'required|min_length[2]|max_length[100]',
            'apellidos'          => 'required|min_length[2]|max_length[100]',
            'correo_electronico' => "required|valid_email|is_unique[usuarios.correo_electronico,usuarios_id,{$id}]",
            'telefono'           => 'permit_empty|max_length[20]',
            'rol_id'             => 'required|is_natural_no_zero',
            'estado'             => 'required|in_list[Activo,Inactivo]'
        ];

        // Validar contraseña solo si se ingresó una nueva
        $nuevaContrasena = (string) $this->request->getPost('contrasena');
        if (!empty($nuevaContrasena)) {
            $reglas['contrasena'] = 'min_length[6]';
        }

        if (!$this->validate($reglas)) {
            return redirect()->back()
                ->withInput()
                ->with('errores', $this->validator->getErrors());
        }

        $nombres = trim($this->request->getPost('nombres'));
        $apellidos = trim($this->request->getPost('apellidos'));
        $correo = trim($this->request->getPost('correo_electronico'));
        $telefono = trim($this->request->getPost('telefono'));
        $rolId = (int) $this->request->getPost('rol_id');
        $estado = $this->request->getPost('estado');
        $gradoEncargado = trim($this->request->getPost('grado_encargado'));

        $datosActualizar = [
            'rol_id'             => $rolId,
            'nombres'            => $nombres,
            'apellidos'          => $apellidos,
            'correo_electronico' => $correo,
            'telefono'           => $telefono ?: null,
            'estado'             => $estado
        ];

        $db = Database::connect();
        $db->transStart();

        // Si se cambió la contraseña
        if (!empty($nuevaContrasena)) {
            $passwordHash = password_hash($nuevaContrasena, PASSWORD_BCRYPT);
            $datosActualizar['contrasena'] = $passwordHash;

            $db->table('contrasenas')
                ->where('usuario_id', $id)
                ->update(['contrasena_hash' => $passwordHash]);
        }

        $modelo->update($id, $datosActualizar);

        // Si es rol Docente, sincronizar o actualizar grado encargado
        if ($rolId === 2) {
            $docenteId = $this->request->getPost('docente_id');
            if (!empty($docenteId)) {
                $db->table('docentes')
                    ->where('docente_id', $docenteId)
                    ->update([
                        'nombre'          => $nombres,
                        'apellido'        => $apellidos,
                        'grado_encargado' => $gradoEncargado ?: 'Sin asignar'
                    ]);
            } else {
                $docenteExistente = $db->table('docentes')
                    ->where('nombre', $nombres)
                    ->where('apellido', $apellidos)
                    ->get()
                    ->getRowArray();

                if ($docenteExistente) {
                    $db->table('docentes')
                        ->where('docente_id', $docenteExistente['docente_id'])
                        ->update([
                            'nombre'          => $nombres,
                            'apellido'        => $apellidos,
                            'grado_encargado' => $gradoEncargado ?: 'Sin asignar'
                        ]);
                } else {
                    $db->table('docentes')->insert([
                        'nombre'          => $nombres,
                        'apellido'        => $apellidos,
                        'grado_encargado' => $gradoEncargado ?: 'Sin asignar'
                    ]);
                }
            }
        }

        $db->transComplete();

        return redirect()->to(site_url('usuarios'))
            ->with('exito', 'Usuario actualizado correctamente.');
    }

    /**
     * Cambia el estado del usuario (Activo / Inactivo)
     */
    public function alternarEstado($id)
    {
        if ($redirect = $this->verificarAdministrador()) {
            return $redirect;
        }

        if ($id == session()->get('usuario_id')) {
            return redirect()->to(site_url('usuarios'))
                ->with('error', 'No puedes desactivar tu propia cuenta de Administrador.');
        }

        $modelo = new UsuariosModel();
        $usuario = $modelo->find($id);

        if (!$usuario) {
            return redirect()->to(site_url('usuarios'))
                ->with('error', 'El usuario no existe.');
        }

        $nuevoEstado = ($usuario['estado'] === 'Activo') ? 'Inactivo' : 'Activo';
        $modelo->update($id, ['estado' => $nuevoEstado]);

        return redirect()->to(site_url('usuarios'))
            ->with('exito', 'Estado del usuario cambiado a "' . $nuevoEstado . '".');
    }

    /**
     * Elimina un usuario del sistema
     */
    public function eliminar($id)
    {
        if ($redirect = $this->verificarAdministrador()) {
            return $redirect;
        }

        if ($id == session()->get('usuario_id')) {
            return redirect()->to(site_url('usuarios'))
                ->with('error', 'No puedes eliminar tu propia cuenta de Administrador.');
        }

        $modelo = new UsuariosModel();
        $usuario = $modelo->find($id);

        if (!$usuario) {
            return redirect()->to(site_url('usuarios'))
                ->with('error', 'El usuario no existe.');
        }

        $modelo->delete($id);

        return redirect()->to(site_url('usuarios'))
            ->with('exito', 'Usuario eliminado correctamente.');
    }
}
