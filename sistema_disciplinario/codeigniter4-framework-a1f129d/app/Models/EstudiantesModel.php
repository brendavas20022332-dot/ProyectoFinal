<?php

namespace App\Models;

use CodeIgniter\Model;

class EstudiantesModel extends Model
{
    protected $table = 'estudiantes';
    protected $primaryKey = 'estudiantes_id';
    protected $allowedFields = [
        'grado_seccion_id',
        'encargado_id',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'genero'
    ];

    protected $useTimestamps = false;

    /**
     * Obtiene los estudiantes con información de grado, sección, encargado y conteo de reportes
     */
    public function obtenerEstudiantesConDetalle(?string $buscar = null)
    {
        $builder = $this->select('
                estudiantes.*,
                g.nombre_grado,
                s.nombre_seccion,
                gs.ciclo_lectivo,
                enc.nombre as enc_nombre,
                enc.apellido as enc_apellido,
                enc.parentesco as enc_parentesco,
                enc.telefono as enc_telefono,
                COUNT(rd.reporte_id) as total_reportes
            ')
            ->join('grados_secciones gs', 'gs.grado_seccion_id = estudiantes.grado_seccion_id', 'left')
            ->join('grados g', 'g.grado_id = gs.grado_id', 'left')
            ->join('secciones s', 's.seccion_id = gs.seccion_id', 'left')
            ->join('encargado enc', 'enc.encargado_id = estudiantes.encargado_id', 'left')
            ->join('reportes_disciplinarios rd', 'rd.estudiante_id = estudiantes.estudiantes_id', 'left')
            ->groupBy('estudiantes.estudiantes_id');

        if (!empty($buscar)) {
            $builder->groupStart()
                ->like('estudiantes.nombres', $buscar)
                ->orLike('estudiantes.apellidos', $buscar)
                ->orLike('g.nombre_grado', $buscar)
                ->orLike('s.nombre_seccion', $buscar)
                ->orLike('estudiantes.estudiantes_id', $buscar)
                ->groupEnd();
        }

        return $builder->orderBy('estudiantes.estudiantes_id', 'ASC')->findAll();
    }
}
