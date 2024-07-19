<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UsuarioModel;

class Usuarios extends ResourceController
{

    public function __construct()
    {
        $this->model = $this->setModel(new UsuarioModel());
    }

    public function list()
    { // lista todos los usuarios en la base de datos
        $usuarios = $this->model->findAll();
        if ($usuarios == null) {
            return $this->failNotFound('No se ha encontrado ningún usuario');
            exit();
        }
        return $this->respond($usuarios);
    }
    public function getOne()
    { // obtiene un usuario por su ID
        # return $this->respond("Hola mundo");
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        try {
            if ($email == null || $password == null) {
                return $this->failValidationErrors('No se ha pasado un correo electrónico o contraseña válidos');
            }
            $usuario = $this->model->where('correo_usuario', $email)->first();
            if ($usuario == null || $usuario['password'] != $password) {
                return $this->failNotFound('Credenciales incorrectas. Inténtelo de nuevo.');
            }
            return $this->respond($usuario);
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor', $e->getMessage());
        }
    }

    public function create()
    { // crea un nuevo usuario
        try {
            $usuario = $this->request->getJSON();
            if ($this->model->insert($usuario)) :
                $usuario->id = $this->model->insertID();
                return $this->respondCreated($usuario);
            else :
                return $this->failValidationErrors($this->model->validation->listErrors());
            endif;
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }

    public function edit($username = null)
    { // edita un usuario
        try {
            if ($username == null) {
                return $this->failValidationErrors('No se ha pasado un nombre de usuario válido');
            }

            $usuario = $this->model->where('username', $username)->first();
            if ($usuario == null) { // esto retira el error de que no se ha encontrado un usuario
                return $this->failNotFound('No se ha encontrado un usuario con el nombre de usuario: ' . $username);
            }
            return $this->respond($usuario);
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }
    public function update($username = null)
    {
        try {
            if ($username == null) {
                return $this->failValidationErrors('No se ha pasado un nombre de usuario válido');
            }
            $usuario = $this->model->where('username', $username)->first();
            if ($usuario == null) {
                return $this->failNotFound('No se ha encontrado un usuario con el nombre de usuario: ' . $username);
            }
            $usuarioUpdate = $this->request->getJSON();
            if ($this->model->update($usuario->id, $usuarioUpdate)) {
                $usuarioUpdate->id = $usuario->id;
                return $this->respondUpdated($usuarioUpdate);
            } else {
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }
    public function delete($username = null)
    {
        try {
            if ($username == null) {
                return $this->failValidationErrors('No se ha pasado un nombre de usuario válido');
            }
            $usuario = $this->model->where('username', $username)->first();
            if ($usuario == null) {
                return $this->failNotFound('No se ha encontrado un usuario con el nombre de usuario: ' . $username);
            }
            if ($this->model->delete($usuario->id)) {
                return $this->respondDeleted($usuario);
            } else {
                return $this->failServerError('No se ha podido eliminar el usuario');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Ha ocurrido un error en el servidor');
        }
    }
}
