<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/geochart', 'HomeController::index');



$routes->get('/admin/kecamatan', "KecamatanController::index");
