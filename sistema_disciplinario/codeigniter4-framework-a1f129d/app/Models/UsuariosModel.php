<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'usuarios_id';
    protected $allowedFields = [
        'rol_id',
        'nombres',
        'apellidos',
        'correo_electronico',
        'telefono',
        'contrasena',
        'estado'
    ];
    protected $useTimestamps = false;

    /**
     * Obtiene un usuario con su rol asociado a partir de su correo electrónico
     */
    public function obtenerPorCorreo(string $correo)
    {
        return $this->select('usuarios.*, roles.nombre as rol_nombre')
                    ->join('roles', 'roles.rol_id = usuarios.rol_id', 'left')
                    ->where('usuarios.correo_electronico', $correo)
                    ->first();
    }

    /**
     * Obtiene todos los usuarios con su rol, datos de docente y total de reportes realizados
     */
    public function obtenerUsuariosConDetalle()
    {
        return $this->select('usuarios.*, roles.nombre as rol_nombre, d.docente_id, d.grado_encargado, COUNT(rd.reporte_id) as total_reportes')
                    ->join('roles', 'roles.rol_id = usuarios.rol_id', 'left')
                    ->join('docentes d', '(d.nombre = usuarios.nombres AND d.apellido = usuarios.apellidos)', 'left')
                    ->join('reportes_disciplinarios rd', 'rd.docente_id = d.docente_id', 'left')
                    ->groupBy('usuarios.usuarios_id')
                    ->orderBy('usuarios.usuarios_id', 'ASC')
                    ->findAll();
    }

    /**
     * Obtiene un usuario específico por su ID con su rol y docente
     */
    public function obtenerUsuarioPorId(int $id)
    {
        return $this->select('usuarios.*, roles.nombre as rol_nombre, d.docente_id, d.grado_encargado')
                    ->join('roles', 'roles.rol_id = usuarios.rol_id', 'left')
                    ->join('docentes d', '(d.nombre = usuarios.nombres AND d.apellido = usuarios.apellidos)', 'left')
                    ->where('usuarios.usuarios_id', $id)
                    ->first();
    }
}
