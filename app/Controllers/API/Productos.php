<?php

namespace App\Controllers\API;

use App\Models\ProductoModel;
use CodeIgniter\RESTful\ResourceController;

class Productos extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new ProductoModel());
    }
    public function index()
    { // retorna todos los productos en la base de datos
        $productos = $this->model->findAll();
        if ($productos == null) {
            return $this->failNotFound('No se ha encontrado ningún producto');
            exit();
        }
        return $this->respond($productos);
    }

    public function create()
    {
        try {
            $producto = $this->request->getJSON();
            if ($this->model->insert($producto)) :
                $producto->id = $this->model->insertID();
                return $this->respondCreated($producto);
            else :
                return $this->failValidationErrors($this->model->validation->listErrors());
            endif;
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }
    public function edit($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationErrors('No se ha pasado un ID valido');
            }

            $producto = $this->model->find($id);
            if ($producto == null) { // esto retira el error de que no se ha encontrado un producto
                return $this->failNotFound('No se ha encontrado un producto con el ID: ' . $id);
            }
            return $this->respond($producto);
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function update($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationErrors('No se ha pasado un ID valido');
            }

            $productoVerificado = $this->model->find($id);
            if ($productoVerificado == null) { // esto retira el error de que no se ha encontrado un producto
                return $this->failNotFound('No se ha encontrado un producto con el ID: ' . $id);
            }

            $producto = $this->request->getJSON();
            if ($this->model->update($id, $producto)) :
                $producto->id = $id;
                return $this->respondUpdated($producto); // retorna un mensaje de actualizado 
            else :
                return $this->failValidationErrors($this->model->validation->listErrors());
            endif;
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function delete($id = null)
    {
        try {
            if ($id == null) {
                return $this->failValidationErrors('No se ha pasado un ID valido');
            }

            $productoVerificado = $this->model->find($id);
            if ($productoVerificado == null) { // esto retira el error de que no se ha encontrado un producto
                return $this->failNotFound('No se ha encontrado un producto con el ID: ' . $id);
            }
        // esto borra el registro
            if ($this->model->delete($id)) :
                return $this->respondDeleted("Eliminado exitosamente"); // retorna un mensaje de actualizado 
            else :
                return $this->failServerError("No se ha podido eliminar el producto");
            endif;
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }
}
