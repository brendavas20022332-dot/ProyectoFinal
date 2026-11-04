<?php

namespace App\Controllers;

use App\Models\EstudiantesModel;
use Config\Database;

class EstudiantesControllers extends BaseController
{
    /**
     * Muestra la lista de todos los estudiantes con buscador y estado de reportes
     */
    public function index()
    {
        $buscar = trim((string) $this->request->getGet('buscar'));

        $modelo = new EstudiantesModel();
        $datos['estudiantes'] = $modelo->obtenerEstudiantesConDetalle($buscar !== '' ? $buscar : null);
        $datos['buscar'] = $buscar;

        $db = Database::connect();

        // Obtener historial de reportes para los modales de cada estudiante
        $reportes = $db->table('reportes_disciplinarios rd')
            ->select('rd.*, tf.nombre as falta_nombre, tf.gravedad as falta_gravedad, er.nombre as estado_nombre, doc.nombre as doc_nombre, doc.apellido as doc_apellido')
            ->join('tipos_de_falta tf', 'tf.tipo_falta_id = rd.tipo_falta_id', 'left')
            ->join('estado_reporte er', 'er.estado_id = rd.estado_id', 'left')
            ->join('docentes doc', 'doc.docente_id = rd.docente_id', 'left')
            ->orderBy('rd.fecha', 'DESC')
            ->orderBy('rd.hora', 'DESC')
            ->get()
            ->getResultArray();

        $reportesAgrupados = [];
        foreach ($reportes as $r) {
            $reportesAgrupados[$r['estudiante_id']][] = $r;
        }
        $datos['reportes_por_estudiante'] = $reportesAgrupados;

        return view('estudiantes', $datos);
    }

    /**
     * Muestra el formulario para crear un nuevo estudiante
     */
    public function crear()
    {
        $db = Database::connect();

        // Obtener grados y secciones disponibles
        $datos['grados_secciones'] = $db->table('grados_secciones gs')
            ->select('gs.grado_seccion_id, gs.grado_id, g.nombre_grado, s.nombre_seccion, gs.ciclo_lectivo')
            ->join('grados g', 'g.grado_id = gs.grado_id')
            ->join('secciones s', 's.seccion_id = gs.seccion_id')
            ->orderBy('g.grado_id', 'ASC')
            ->get()
            ->getResultArray();

        // Obtener encargados disponibles
        $datos['encargados'] = $db->table('encargado')
            ->orderBy('nombre', 'ASC')
            ->get()
            ->getResultArray();

        // Preselección si viene desde la vista de grados
        $datos['grado_id_preseleccionado'] = $this->request->getGet('grado_id');
        $datos['grado_seccion_preseleccionado'] = $this->request->getGet('grado_seccion_id');

        return view('estudiantes_crear', $datos);
    }

    /**
     * Guarda un nuevo estudiante en la base de datos
     */
    public function guardar()
    {
        $reglas = [
            'nombres'          => 'required|min_length[2]|max_length[100]',
            'apellidos'        => 'required|min_length[2]|max_length[100]',
            'fecha_nacimiento' => 'required|valid_date',
            'genero'           => 'required',
            'grado_seccion_id' => 'required|is_natural_no_zero',
            'encargado_id'     => 'required|is_natural_no_zero'
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()
                ->withInput()
                ->with('errores', $this->validator->getErrors());
        }

        $modelo = new EstudiantesModel();
        $modelo->insert([
            'nombres'          => trim($this->request->getPost('nombres')),
            'apellidos'        => trim($this->request->getPost('apellidos')),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'genero'           => $this->request->getPost('genero'),
            'grado_seccion_id' => $this->request->getPost('grado_seccion_id'),
            'encargado_id'     => $this->request->getPost('encargado_id')
        ]);

        return redirect()->to(site_url('estudiantes'))
            ->with('exito', 'Estudiante registrado correctamente.');
    }

    /**
     * Muestra el formulario para editar un estudiante existente
     */
    public function editar($id)
    {
        $modelo = new EstudiantesModel();
        $estudiante = $modelo->find($id);

        if (!$estudiante) {
            return redirect()->to(site_url('estudiantes'))
                ->with('error', 'El estudiante seleccionado no existe.');
        }

        $db = Database::connect();

        $datos['estudiante'] = $estudiante;

        // Grados y secciones disponibles
        $datos['grados_secciones'] = $db->table('grados_secciones gs')
            ->select('gs.grado_seccion_id, g.nombre_grado, s.nombre_seccion, gs.ciclo_lectivo')
            ->join('grados g', 'g.grado_id = gs.grado_id')
            ->join('secciones s', 's.seccion_id = gs.seccion_id')
            ->orderBy('g.grado_id', 'ASC')
            ->get()
            ->getResultArray();

        // Encargados disponibles
        $datos['encargados'] = $db->table('encargado')
            ->orderBy('nombre', 'ASC')
            ->get()
            ->getResultArray();

        return view('estudiantes_editar', $datos);
    }

    /**
     * Actualiza los datos de un estudiante
     */
    public function actualizar($id)
    {
        $modelo = new EstudiantesModel();
        $estudiante = $modelo->find($id);

        if (!$estudiante) {
            return redirect()->to(site_url('estudiantes'))
                ->with('error', 'El estudiante no existe.');
        }

        $reglas = [
            'nombres'          => 'required|min_length[2]|max_length[100]',
            'apellidos'        => 'required|min_length[2]|max_length[100]',
            'fecha_nacimiento' => 'required|valid_date',
            'genero'           => 'required',
            'grado_seccion_id' => 'required|is_natural_no_zero',
            'encargado_id'     => 'required|is_natural_no_zero'
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()
                ->withInput()
                ->with('errores', $this->validator->getErrors());
        }

        $modelo->update($id, [
            'nombres'          => trim($this->request->getPost('nombres')),
            'apellidos'        => trim($this->request->getPost('apellidos')),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'genero'           => $this->request->getPost('genero'),
            'grado_seccion_id' => $this->request->getPost('grado_seccion_id'),
            'encargado_id'     => $this->request->getPost('encargado_id')
        ]);

        return redirect()->to(site_url('estudiantes'))
            ->with('exito', 'Estudiante actualizado correctamente.');
    }

    /**
     * Elimina a un estudiante
     */
    public function eliminar($id)
    {
        $modelo = new EstudiantesModel();
        $estudiante = $modelo->find($id);

        if (!$estudiante) {
            return redirect()->to(site_url('estudiantes'))
                ->with('error', 'El estudiante no existe.');
        }

        $modelo->delete($id);

        return redirect()->to(site_url('estudiantes'))
            ->with('exito', 'Estudiante eliminado correctamente.');
    }
}
