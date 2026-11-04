<?php

namespace App\Controllers;

use App\Models\ReportesModel;
use Config\Database;

class ReportesControllers extends BaseController
{
    /**
     * Muestra la lista de todos los reportes disciplinarios
     */
    public function index()
    {
        $modelo = new ReportesModel();
        $datos['reportes'] = $modelo->obtenerReportesConDetalle();

        $db = Database::connect();
        $datos['docentes'] = $db->table('docentes')->orderBy('nombre', 'ASC')->get()->getResultArray();
        $datos['docente_filtro'] = trim((string) $this->request->getGet('docente'));

        return view('reportes', $datos);
    }

    /**
     * Muestra el formulario para crear un nuevo reporte
     */
    public function crear()
    {
        $db = Database::connect();

        // Estudiantes con su grado y sección
        $datos['estudiantes'] = $db->table('estudiantes est')
            ->select('est.estudiantes_id, est.nombres, est.apellidos, g.nombre_grado, s.nombre_seccion')
            ->join('grados_secciones gs', 'gs.grado_seccion_id = est.grado_seccion_id', 'left')
            ->join('grados g', 'g.grado_id = gs.grado_id', 'left')
            ->join('secciones s', 's.seccion_id = gs.seccion_id', 'left')
            ->orderBy('est.nombres', 'ASC')
            ->get()
            ->getResultArray();

        // Docentes disponibles
        $datos['docentes'] = $db->table('docentes')
            ->orderBy('nombre', 'ASC')
            ->get()
            ->getResultArray();

        // Tipos de falta disciplinaria
        $datos['tipos_falta'] = $db->table('tipos_de_falta')
            ->orderBy('tipo_falta_id', 'ASC')
            ->get()
            ->getResultArray();

        // Estados del reporte
        $datos['estados'] = $db->table('estado_reporte')
            ->orderBy('estado_id', 'ASC')
            ->get()
            ->getResultArray();

        // Estudiante preseleccionado si viene por parámetro GET
        $datos['estudiante_preseleccionado'] = $this->request->getGet('estudiante_id');

        return view('reportes_crear', $datos);
    }

    /**
     * Guarda el nuevo reporte disciplinario
     */
    public function guardar()
    {
        $reglas = [
            'estudiante_id'     => 'required|is_natural_no_zero',
            'docente_id'        => 'required|is_natural_no_zero',
            'tipo_falta_id'     => 'required|is_natural_no_zero',
            'estado_id'         => 'required|is_natural_no_zero',
            'fecha'             => 'required|valid_date',
            'hora'              => 'required',
            'motivo'            => 'required|min_length[3]|max_length[255]',
            'descripcion_falta' => 'required|min_length[5]'
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()
                ->withInput()
                ->with('errores', $this->validator->getErrors());
        }

        $modelo = new ReportesModel();
        $modelo->insert([
            'estudiante_id'     => $this->request->getPost('estudiante_id'),
            'docente_id'        => $this->request->getPost('docente_id'),
            'tipo_falta_id'     => $this->request->getPost('tipo_falta_id'),
            'estado_id'         => $this->request->getPost('estado_id'),
            'fecha'             => $this->request->getPost('fecha'),
            'hora'              => $this->request->getPost('hora'),
            'motivo'            => trim($this->request->getPost('motivo')),
            'descripcion_falta' => trim($this->request->getPost('descripcion_falta')),
            'acciones_tomadas'  => trim($this->request->getPost('acciones_tomadas'))
        ]);

        return redirect()->to(site_url('reportes'))
            ->with('exito', 'Reporte disciplinario registrado correctamente.');
    }

    /**
     * Elimina un reporte disciplinario
     */
    public function eliminar($id)
    {
        $modelo = new ReportesModel();
        $reporte = $modelo->find($id);

        if (!$reporte) {
            return redirect()->to(site_url('reportes'))
                ->with('error', 'El reporte no existe.');
        }

        $modelo->delete($id);

        return redirect()->to(site_url('reportes'))
            ->with('exito', 'Reporte disciplinario eliminado correctamente.');
    }

    /**
     * Muestra la vista oficial imprimible y lista para guardar como PDF
     */
    public function imprimir($id)
    {
        $modelo = new ReportesModel();
        $reporte = $modelo->obtenerReportePorId((int) $id);

        if (!$reporte) {
            return redirect()->to(site_url('reportes'))
                ->with('error', 'El reporte disciplinario no fue encontrado.');
        }

        return view('reportes_imprimir', ['reporte' => $reporte]);
    }

    /**
     * Descarga el reporte disciplinario en formato Microsoft Word (.doc)
     */
    public function descargarWord($id)
    {
        $modelo = new ReportesModel();
        $reporte = $modelo->obtenerReportePorId((int) $id);

        if (!$reporte) {
            return redirect()->to(site_url('reportes'))
                ->with('error', 'El reporte disciplinario no fue encontrado.');
        }

        $html = view('reportes_word', ['reporte' => $reporte]);

        $apellidos = strtr(
            $reporte['est_apellidos'] ?? 'Alumno',
            ['á'=>'a', 'é'=>'e', 'í'=>'i', 'ó'=>'o', 'ú'=>'u', 'ñ'=>'n', 'Á'=>'A', 'É'=>'E', 'Í'=>'I', 'Ó'=>'O', 'Ú'=>'U', 'Ñ'=>'N']
        );
        $apellidos = preg_replace('/[^A-Za-z0-9_-]/', '_', $apellidos);
        $nombreArchivo = 'Reporte_Disciplinario_' . $reporte['reporte_id'] . '_' . $apellidos . '.doc';

        return $this->response
            ->setHeader('Content-Type', 'application/msword; charset=UTF-8')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $nombreArchivo . '"')
            ->setHeader('Cache-Control', 'max-age=0, no-cache, no-store, must-revalidate')
            ->setHeader('Pragma', 'no-cache')
            ->setBody($html);
    }
}
