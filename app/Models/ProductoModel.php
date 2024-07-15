<?php
namespace App\Models;
use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    protected $allowedFields = ['nombre_producto', 'descripcion_producto', 'tipo'];
    protected $returnType = 'array';
    // gestiona las fechas de creación y actualización
    # protected $useTimestamps = true;
    # protected $createdField = 'created_at';
    # protected $updatedField = 'updated_at';
   /*  Aqui se definen las reglas de la base de datos con todos sus parametros para evitar conflictos con los datos enviados a la base de datos
    cada regla es separada por el signo de OR   */ 

    protected $validationRules = [
        'nombre_producto' => 'required|alpha_numeric_space|min_length[3]|max_length[100]',
        'descripcion_producto' => 'permit_empty|alpha_numeric_space|min_length[3]|max_length[250]',
        'tipo' => 'required|alpha|min_length[2]'
    ];
    // retorna estos mensajes de error si no se cumplen las reglas de la base de datos
    protected $validationMessage = [
        'nombre_producto' => [
            'required' => 'El nombre del producto es requerido',
            'alpha_numeric_space' => 'El nombre del producto solo puede contener caracteres alfanumérico',
            'min_length' => 'El nombre del producto debe tener al menos 3 caracteres',
            'max_length' => 'El nombre del producto no puede tener mas de 100 caracteres'
        ],
        'descripcion_producto' => [
            'alpha_numeric_space' => 'La descripción del producto solo puede contener caracteres alfanuméricos',
            'min_length' => 'La descripción del producto debe tener al menos 3 caracteres',
            'max_length' => 'La descripción del producto no puede tener mas de 250 caracteres'
        ],
        'tipo' => [
            'required' => 'El tipo de producto es requerido',
            'alpha' => 'El tipo de producto solo puede contener caracteres alfabéticos',
            'min_length' => 'El tipo de producto debe tener al menos 2 caracteres'
        ]
    ];
    // no se puede omitir ningún tipo de validación
    protected $skipValidation = false;

}   