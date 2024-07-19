<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['nombre_usuario', 'apellido_usuario', 'correo_usuario', 'username', 'password'];
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField = 'createdAt';
    protected $updatedField = 'updatedAt';

    protected $validationRules = [
        'nombre_usuario' => 'required|alpha_numeric_space|min_length[3]|max_length[100]',
        'apellido_usuario' => 'required|alpha_numeric_space|min_length[3]|max_length[100]',
        'correo_usuario' => 'required|valid_email|is_unique[usuario.correo_usuario]|min_length[3]|max_length[250]',
        'username' => 'alpha_numeric_space|min_length[3]|max_length[100]',
        'password' => 'required|max_length[250]'
    ];
    // retorna estos mensajes de error si no se cumplen las reglas de la base de datos
    protected $validationMessage = [
        'nombre_usuario' => [
            'required' => 'El nombre es requerido',
            'alpha_numeric_space' => 'El nombre solo puede contener caracteres alfanuméricos y espacios',
            'min_length' => 'El nombre debe tener al menos 3 caracteres',
            'max_length' => 'El nombre no puede tener más de 100 caracteres'
        ],
        'apellido_usuario' => [
            'required' => 'El apellido es requerido',
            'alpha_numeric_space' => 'El apellido solo puede contener caracteres alfanuméricos y espacios',
            'min_length' => 'El apellido debe tener al menos 3 caracteres',
            'max_length' => 'El apellido no puede tener más de 100 caracteres'
        ],
        'correo_usuario' => [
            'required' => 'El correo es requerido',
            'valid_email' => 'El correo no es válido',
            'is_unique' => 'El correo ya está registrado',
            'min_length' => 'El correo debe tener al menos 3 caracteres',
            'max_length' => 'El correo no puede tener más de 250 caracteres'
        ],
        'username' => [
            'alpha_numeric_space' => 'El nombre de usuario solo puede contener caracteres alfanuméricos y espacios',
            'min_length' => 'El nombre de usuario debe tener al menos 3 caracteres',
            'max_length' => 'El nombre de usuario no puede tener más de 100 caracteres'
        ], // validad si el usuario solo puede tener letras y numeros, guines bajos o medios y puntos.
        'password' => [
            'required' => 'La contraseña es requerida',
            'min_length' => 'La contraseña debe tener al menos 250 caracteres'
        ],
    ];

    // no se puede omitir ningún tipo de validación
    protected $skipValidation = false;
}
