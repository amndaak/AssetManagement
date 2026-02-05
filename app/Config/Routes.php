<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AdminController::index');
$routes->post('/login', 'AdminController::auth');
$routes->get('/logout', 'AdminController::logout');

$routes->get('/dashboard', 'AdminController::dashboard');
$routes->post('/update-status/(:num)', 'AssetController::editMutasi/$1');

$routes->post('/submit', 'AssetController::simpanMutasi');