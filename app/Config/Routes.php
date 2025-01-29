<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/admin', 'Home::index');



// kecamatan
$routes->get('/admin/kecamatan', "KecamatanController::index");
$routes->get('/admin/kecamatan/create', "KecamatanController::create");
$routes->post('/admin/kecamatan/store', "KecamatanController::store");
$routes->get('/admin/kecamatan/edit/(:segment)', 'KecamatanController::edit/$1');
$routes->post('/admin/kecamatan/update/(:segment)', 'KecamatanController::update/$1');
$routes->get('/admin/kecamatan/delete/(:num)', 'KecamatanController::delete/$1');


$routes->get('/admin/tahun', "TahunController::index");
$routes->get('/admin/tahun/create', "TahunController::create");
$routes->post('/admin/tahun/store', "TahunController::store");
$routes->get('/admin/tahun/delete/(:num)', 'TahunController::delete/$1');
$routes->get('/admin/tahun/edit/(:segment)', 'TahunController::edit/$1');
$routes->post('/admin/tahun/update/(:segment)', 'TahunController::update/$1');

$routes->get('/admin/puskesmas', "PuskesmasController::index");
$routes->get('/admin/puskesmas/create', "PuskesmasController::create");
$routes->post('/admin/puskesmas/store', "PuskesmasController::store");
$routes->get('/admin/puskesmas/delete/(:num)', 'PuskesmasController::delete/$1');
$routes->get('/admin/puskesmas/edit/(:segment)', 'PuskesmasController::edit/$1');
$routes->post('/admin/puskesmas/update/(:segment)', 'PuskesmasController::update/$1');


$routes->get('/admin/dbd', "DataKasusDbdController::index");
$routes->get('/admin/dbd/create', "DataKasusDbdController::create");
$routes->post('/admin/dbd/store', "DataKasusDbdController::store");
$routes->get('/admin/dbd/delete/(:num)', 'DataKasusDbdController::delete/$1');
$routes->get('/admin/dbd/edit/(:segment)', 'DataKasusDbdController::edit/$1');
$routes->post('/admin/dbd/update/(:segment)', 'DataKasusDbdController::update/$1');



$routes->get('/admin/pemetaan', 'PemetaanController::index');
