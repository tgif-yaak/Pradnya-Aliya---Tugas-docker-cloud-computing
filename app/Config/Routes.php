<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
// === AUTH ===
$routes->get('/login-doa', 'Auth::login');
$routes->post('/proses-login', 'Auth::prosesLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/register/save', 'Auth::saveRegister');
$routes->get('/logout', 'Auth::logout');

// === DASHBOARD TRACKING IBADAH ===
$routes->get('/ibadah', 'Ibadah::index');                          
$routes->get('/ibadah/tambah-tracking', 'Ibadah::formTracking'); 
$routes->post('/ibadah/simpan-tracking', 'Ibadah::simpanTracking'); 
$routes->post('/ibadah/tambah', 'Ibadah::tambah');                
$routes->post('/ibadah/update/(:num)', 'Ibadah::update/$1');      
$routes->get('/ibadah/hapus/(:num)', 'Ibadah::hapus/$1');         
$routes->get('/ibadah/detail/(:num)', 'Ibadah::detail/$1');
$routes->get('/ibadah/edit-tracking/(:num)', 'Ibadah::editTracking/$1');
$routes->post('/ibadah/update-tracking/(:num)', 'Ibadah::updateTracking/$1');
$routes->get('/ibadah/statistik', 'Ibadah::statistik');

// === API ===
$routes->group('api', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('ibadah', 'IbadahApi::index');                   
    $routes->post('ibadah', 'IbadahApi::create');                  
    $routes->get('ibadah/(:num)', 'IbadahApi::show/$1');         
    $routes->delete('ibadah/(:num)', 'IbadahApi::delete/$1');      
});
