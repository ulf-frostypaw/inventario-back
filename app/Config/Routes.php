<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers\API'], function ($routes) {
    $routes->get('productos', 'Productos::index');
    $routes->post('productos/create', 'Productos::create'); // crea productos
    $routes->get('productos/edit/(:num)', 'Productos::edit/$1'); // lista un solo producto para editarlo
    $routes->put('productos/update/(:num)', 'Productos::update/$1'); // actualiza productos
    $routes->delete('productos/delete/(:num)', 'Productos::delete/$1'); // elimina productos
    
    $routes->group('users', function ($routes) {
        $routes->get('list', 'Usuarios::index');
        $routes->post('login', 'Usuarios::getOne');
        $routes->post('create', 'Usuarios::create');
        $routes->get('edit/(:num)', 'Usuarios::edit/$1');
        $routes->put('update/(:num)', 'Usuarios::update/$1');
        $routes->delete('delete/(:num)', 'Usuarios::delete/$1');
    });
});
