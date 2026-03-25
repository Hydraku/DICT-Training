<?php


use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


// Auth routes (public)
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::attemptRegister');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');




$routes->group('tasks', ['filter' => 'auth'],  function ($routes) {
    $routes->get('/',          'TaskController::index');
    $routes->get('show/(:num)', 'TaskController::show/$1');
    $routes->get('create',     'TaskController::create');
    $routes->post('store',     'TaskController::store');
    $routes->get('edit/(:num)', 'TaskController::edit/$1');
    $routes->post('update/(:num)', 'TaskController::update/$1');
    $routes->post('delete/(:num)', 'TaskController::delete/$1'); // POST!
});