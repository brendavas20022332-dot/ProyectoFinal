<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportesModel extends Model
{
    protected $table = 'reportes_disciplinarios';
    protected $primaryKey = 'reporte_id';
    protected $allowedFields = [
        'estudiante_id',
        'docente_id',
        'tipo_falta_id',
        'estado_id',
        'fecha',
        'hora',
        'motivo',
        'descripcion_falta',
        'acciones_tomadas'
    ];

    protected $useTimestamps = false;

    /**
     * Obtiene los reportes con los nombres de estudiantes, docentes, tipos de falta y estados
     */
    public function obtenerReportesConDetalle()
    {
        return $this->select('
                reportes_disciplinarios.*,
                est.nombres as est_nombres,
                est.apellidos as est_apellidos,
                g.nombre_grado,
                sec.nombre_seccion,
                doc.nombre as doc_nombre,
                doc.apellido as doc_apellido,
                tf.nombre as falta_nombre,
                tf.gravedad as falta_gravedad,
                er.nombre as estado_nombre
            ')
            ->join('estudiantes est', 'est.estudiantes_id = reportes_disciplinarios.estudiante_id', 'left')
            ->join('grados_secciones gs', 'gs.grado_seccion_id = est.grado_seccion_id', 'left')
            ->join('grados g', 'g.grado_id = gs.grado_id', 'left')
            ->join('secciones sec', 'sec.seccion_id = gs.seccion_id', 'left')
            ->join('docentes doc', 'doc.docente_id = reportes_disciplinarios.docente_id', 'left')
            ->join('tipos_de_falta tf', 'tf.tipo_falta_id = reportes_disciplinarios.tipo_falta_id', 'left')
            ->join('estado_reporte er', 'er.estado_id = reportes_disciplinarios.estado_id', 'left')
            ->orderBy('reportes_disciplinarios.fecha', 'DESC')
            ->orderBy('reportes_disciplinarios.hora', 'DESC')
            ->findAll();
    }

    /**
     * Obtiene un reporte específico con todos los detalles necesarios para imprimir o descargar
     */
    public function obtenerReportePorId(int $id)
    {
        return $this->select('
                reportes_disciplinarios.*,
                est.nombres as est_nombres,
                est.apellidos as est_apellidos,
                est.genero as est_genero,
                est.fecha_nacimiento as est_fecha_nacimiento,
                g.nombre_grado,
                sec.nombre_seccion,
                gs.ciclo_lectivo,
                doc.nombre as doc_nombre,
                doc.apellido as doc_apellido,
                doc.grado_encargado as doc_grado_encargado,
                tf.nombre as falta_nombre,
                tf.gravedad as falta_gravedad,
                tf.descripcion as falta_descripcion,
                er.nombre as estado_nombre,
                enc.nombre as enc_nombre,
                enc.apellido as enc_apellido,
                enc.parentesco as enc_parentesco,
                enc.telefono as enc_telefono
            ')
            ->join('estudiantes est', 'est.estudiantes_id = reportes_disciplinarios.estudiante_id', 'left')
            ->join('encargado enc', 'enc.encargado_id = est.encargado_id', 'left')
            ->join('grados_secciones gs', 'gs.grado_seccion_id = est.grado_seccion_id', 'left')
            ->join('grados g', 'g.grado_id = gs.grado_id', 'left')
            ->join('secciones sec', 'sec.seccion_id = gs.seccion_id', 'left')
            ->join('docentes doc', 'doc.docente_id = reportes_disciplinarios.docente_id', 'left')
            ->join('tipos_de_falta tf', 'tf.tipo_falta_id = reportes_disciplinarios.tipo_falta_id', 'left')
            ->join('estado_reporte er', 'er.estado_id = reportes_disciplinarios.estado_id', 'left')
            ->where('reportes_disciplinarios.reporte_id', $id)
            ->first();
    }
}
