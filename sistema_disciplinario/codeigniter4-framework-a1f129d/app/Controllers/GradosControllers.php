<?php

namespace App\Controllers;

use App\Models\GradosModel;
use App\Models\GradosSeccionesModel;
use Config\Database;

class GradosControllers extends BaseController
{
    /**
     * Muestra la lista de todos los grados con sus secciones y cantidad de estudiantes
     */
    public function index()
    {
        $modelo = new GradosModel();
        $datos['grados'] = $modelo->obtenerGradosConEstadisticas();

        return view('grados', $datos);
    }

    /**
     * Muestra el formulario para crear un nuevo grado
     */
    public function crear()
    {
        $db = Database::connect();
        $datos['secciones'] = $db->table('secciones')->orderBy('nombre_seccion', 'ASC')->get()->getResultArray();

        return view('grados_crear', $datos);
    }

    /**
     * Guarda el nuevo grado en la base de datos
     */
    public function guardar()
    {
        $reglas = [
            'nombre_grado' => [
                'rules'  => 'required|min_length[3]|max_length[100]|is_unique[grados.nombre_grado]',
                'errors' => [
                    'required'    => 'El nombre del grado es obligatorio.',
                    'min_length'  => 'El nombre debe tener al menos 3 caracteres.',
                    'is_unique'   => 'Este grado ya se encuentra registrado.'
                ]
            ]
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()
                ->withInput()
                ->with('errores', $this->validator->getErrors());
        }

        $nombreGrado = trim($this->request->getPost('nombre_grado'));
        $seccionesSeleccionadas = $this->request->getPost('secciones') ?? [];
        $cicloLectivo = (int) ($this->request->getPost('ciclo_lectivo') ?? date('Y'));

        $modeloGrados = new GradosModel();
        $gradoId = $modeloGrados->insert([
            'nombre_grado' => $nombreGrado
        ]);

        // Si no seleccionó secciones, asociar por defecto con Sección 'C' (seccion_id = 1)
        if (empty($seccionesSeleccionadas)) {
            $seccionesSeleccionadas = [1];
        }

        $modeloGS = new GradosSeccionesModel();
        foreach ($seccionesSeleccionadas as $seccionId) {
            $modeloGS->insert([
                'grado_id'      => $gradoId,
                'seccion_id'    => $seccionId,
                'ciclo_lectivo' => $cicloLectivo
            ]);
        }

        return redirect()->to(site_url('grados'))
            ->with('exito', 'Grado "' . esc($nombreGrado) . '" registrado y configurado con éxito.');
    }

    /**
     * Muestra el formulario para editar un grado existente
     */
    public function editar($id)
    {
        $modelo = new GradosModel();
        $grado = $modelo->find($id);

        if (!$grado) {
            return redirect()->to(site_url('grados'))
                ->with('error', 'El grado seleccionado no existe.');
        }

        $db = Database::connect();

        $datos['grado'] = $grado;
        $datos['secciones'] = $db->table('secciones')->orderBy('nombre_seccion', 'ASC')->get()->getResultArray();

        // Secciones que ya tiene asignadas este grado
        $seccionesAsignadas = $db->table('grados_secciones')
            ->select('seccion_id')
            ->where('grado_id', $id)
            ->get()
            ->getResultArray();

        $datos['secciones_asignadas'] = array_column($seccionesAsignadas, 'seccion_id');

        return view('grados_editar', $datos);
    }

    /**
     * Actualiza el grado y sus secciones
     */
    public function actualizar($id)
    {
        $modelo = new GradosModel();
        $grado = $modelo->find($id);

        if (!$grado) {
            return redirect()->to(site_url('grados'))
                ->with('error', 'El grado no existe.');
        }

        $reglas = [
            'nombre_grado' => [
                'rules'  => "required|min_length[3]|max_length[100]|is_unique[grados.nombre_grado,grado_id,{$id}]",
                'errors' => [
                    'required'    => 'El nombre del grado es obligatorio.',
                    'is_unique'   => 'Ya existe otro grado con este nombre.'
                ]
            ]
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()
                ->withInput()
                ->with('errores', $this->validator->getErrors());
        }

        $nombreGrado = trim($this->request->getPost('nombre_grado'));
        $modelo->update($id, ['nombre_grado' => $nombreGrado]);

        // Secciones seleccionadas
        $seccionesSeleccionadas = $this->request->getPost('secciones') ?? [];
        $cicloLectivo = (int) ($this->request->getPost('ciclo_lectivo') ?? date('Y'));

        $db = Database::connect();

        // Agregar nuevas secciones seleccionadas que no existan aún
        $modeloGS = new GradosSeccionesModel();
        foreach ($seccionesSeleccionadas as $seccionId) {
            $existe = $db->table('grados_secciones')
                ->where('grado_id', $id)
                ->where('seccion_id', $seccionId)
                ->countAllResults();

            if ($existe === 0) {
                $modeloGS->insert([
                    'grado_id'      => $id,
                    'seccion_id'    => $seccionId,
                    'ciclo_lectivo' => $cicloLectivo
                ]);
            }
        }

        return redirect()->to(site_url('grados'))
            ->with('exito', 'Grado actualizado correctamente.');
    }

    /**
     * Elimina un grado si no tiene estudiantes registrados
     */
    public function eliminar($id)
    {
        $modelo = new GradosModel();
        $grado = $modelo->find($id);

        if (!$grado) {
            return redirect()->to(site_url('grados'))
                ->with('error', 'El grado no existe.');
        }

        $db = Database::connect();

        // Verificar si tiene estudiantes inscritos
        $totalEstudiantes = $db->table('estudiantes e')
            ->join('grados_secciones gs', 'gs.grado_seccion_id = e.grado_seccion_id')
            ->where('gs.grado_id', $id)
            ->countAllResults();

        if ($totalEstudiantes > 0) {
            return redirect()->to(site_url('grados'))
                ->with('error', 'No se puede eliminar el grado "' . esc($grado['nombre_grado']) . '" porque tiene ' . $totalEstudiantes . ' estudiante(s) inscrito(s). Primero debes reubicar o eliminar a los estudiantes.');
        }

        // Eliminar las relaciones en grados_secciones
        $db->table('grados_secciones')->where('grado_id', $id)->delete();

        // Eliminar el grado
        $modelo->delete($id);

        return redirect()->to(site_url('grados'))
            ->with('exito', 'Grado "' . esc($grado['nombre_grado']) . '" eliminado correctamente.');
    }

    /**
     * Muestra los estudiantes inscritos en un grado específico y permite ingresar nuevos
     */
    public function estudiantes($gradoId)
    {
        $modelo = new GradosModel();
        $grado = $modelo->find($gradoId);

        if (!$grado) {
            return redirect()->to(site_url('grados'))
                ->with('error', 'El grado no existe.');
        }

        $db = Database::connect();

        $datos['grado'] = $grado;

        // Estudiantes inscritos en este grado
        $datos['estudiantes'] = $db->table('estudiantes e')
            ->select('e.*, g.nombre_grado, s.nombre_seccion, gs.ciclo_lectivo, enc.nombre as enc_nombre, enc.apellido as enc_apellido, enc.parentesco as enc_parentesco, enc.telefono as enc_telefono')
            ->join('grados_secciones gs', 'gs.grado_seccion_id = e.grado_seccion_id')
            ->join('grados g', 'g.grado_id = gs.grado_id')
            ->join('secciones s', 's.seccion_id = gs.seccion_id')
            ->join('encargado enc', 'enc.encargado_id = e.encargado_id', 'left')
            ->where('gs.grado_id', $gradoId)
            ->orderBy('e.nombres', 'ASC')
            ->get()
            ->getResultArray();

        // Secciones disponibles para este grado
        $datos['grados_secciones'] = $db->table('grados_secciones gs')
            ->select('gs.grado_seccion_id, s.nombre_seccion, gs.ciclo_lectivo')
            ->join('secciones s', 's.seccion_id = gs.seccion_id')
            ->where('gs.grado_id', $gradoId)
            ->get()
            ->getResultArray();

        return view('grados_estudiantes', $datos);
    }
}
