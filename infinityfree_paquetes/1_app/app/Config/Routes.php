<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Ruta raíz: si está logueado va al inicio, si no va al login
$routes->get('/', function() {
    if (session()->get('isLoggedIn')) {
        return redirect()->to(site_url('inicio'));
    }
    return redirect()->to(site_url('login'));
});

// Rutas de autenticación (Inicio de sesión y cierre de sesión)
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::autenticar');
$routes->get('logout', 'AuthController::logout');

// Rutas protegidas (requieren haber iniciado sesión)
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('inicio', function() {
        return view('inicio');
    });

    // Módulo de Estudiantes (CRUD)
    $routes->get('estudiantes', 'EstudiantesControllers::index');
    $routes->get('estudiantes/crear', 'EstudiantesControllers::crear');
    $routes->post('estudiantes/guardar', 'EstudiantesControllers::guardar');
    $routes->get('estudiantes/editar/(:num)', 'EstudiantesControllers::editar/$1');
    $routes->post('estudiantes/actualizar/(:num)', 'EstudiantesControllers::actualizar/$1');
    $routes->post('estudiantes/eliminar/(:num)', 'EstudiantesControllers::eliminar/$1');

    // Módulo de Reportes Disciplinarios
    $routes->get('reportes', 'ReportesControllers::index');
    $routes->get('reportes/crear', 'ReportesControllers::crear');
    $routes->post('reportes/guardar', 'ReportesControllers::guardar');
    $routes->post('reportes/eliminar/(:num)', 'ReportesControllers::eliminar/$1');
    $routes->get('reportes/imprimir/(:num)', 'ReportesControllers::imprimir/$1');
    $routes->get('reportes/descargar-word/(:num)', 'ReportesControllers::descargarWord/$1');

    // Módulo de Grados y Secciones (CRUD + ingreso de estudiantes)
    $routes->get('grados', 'GradosControllers::index');
    $routes->get('grados/crear', 'GradosControllers::crear');
    $routes->post('grados/guardar', 'GradosControllers::guardar');
    $routes->get('grados/editar/(:num)', 'GradosControllers::editar/$1');
    $routes->post('grados/actualizar/(:num)', 'GradosControllers::actualizar/$1');
    $routes->post('grados/eliminar/(:num)', 'GradosControllers::eliminar/$1');
    $routes->get('grados/estudiantes/(:num)', 'GradosControllers::estudiantes/$1');

    // Módulo de Gestión de Usuarios y Maestros (Solo Administrador)
    $routes->get('usuarios', 'UsuariosControllers::index');
    $routes->get('usuarios/crear', 'UsuariosControllers::crear');
    $routes->post('usuarios/guardar', 'UsuariosControllers::guardar');
    $routes->get('usuarios/editar/(:num)', 'UsuariosControllers::editar/$1');
    $routes->post('usuarios/actualizar/(:num)', 'UsuariosControllers::actualizar/$1');
    $routes->post('usuarios/eliminar/(:num)', 'UsuariosControllers::eliminar/$1');
    $routes->post('usuarios/alternar-estado/(:num)', 'UsuariosControllers::alternarEstado/$1');
});
