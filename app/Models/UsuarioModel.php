<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = [];
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField = 'createdAt';
    protected $updatedField = 'updatedAt';

    protected $validationRules = [];
    // retorna estos mensajes de error si no se cumplen las reglas de la base de datos
    protected $validationMessage = [];

    // no se puede omitir ningún tipo de validación
    protected $skipValidation = false;
}
