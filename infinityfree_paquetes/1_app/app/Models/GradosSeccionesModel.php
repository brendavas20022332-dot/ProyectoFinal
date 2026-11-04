<?php

namespace App\Models;

use CodeIgniter\Model;

class GradosSeccionesModel extends Model
{
    protected $table = 'grados_secciones';
    protected $primaryKey = 'grado_seccion_id';
    protected $allowedFields = ['grado_id', 'seccion_id', 'ciclo_lectivo'];
    protected $useTimestamps = false;
}
