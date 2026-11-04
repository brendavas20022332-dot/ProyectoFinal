<?php

namespace App\Models;

use CodeIgniter\Model;

class GradosModel extends Model
{
    protected $table = 'grados';
    protected $primaryKey = 'grado_id';
    protected $allowedFields = ['nombre_grado'];
    protected $useTimestamps = false;

    /**
     * Obtiene todos los grados con el conteo de estudiantes y sus secciones asociadas
     */
    public function obtenerGradosConEstadisticas()
    {
        $db = \Config\Database::connect();

        $grados = $this->orderBy('grado_id', 'ASC')->findAll();

        foreach ($grados as &$grado) {
            // Secciones asociadas a este grado
            $secciones = $db->table('grados_secciones gs')
                ->select('gs.grado_seccion_id, s.nombre_seccion, gs.ciclo_lectivo')
                ->join('secciones s', 's.seccion_id = gs.seccion_id')
                ->where('gs.grado_id', $grado['grado_id'])
                ->get()
                ->getResultArray();

            $grado['secciones'] = $secciones;

            // Conteo total de estudiantes en este grado
            $totalEstudiantes = $db->table('estudiantes e')
                ->join('grados_secciones gs', 'gs.grado_seccion_id = e.grado_seccion_id')
                ->where('gs.grado_id', $grado['grado_id'])
                ->countAllResults();

            $grado['total_estudiantes'] = $totalEstudiantes;
        }

        return $grados;
    }
}
