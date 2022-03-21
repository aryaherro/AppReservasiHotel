<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// membuka halaman login untuk awal atau saat  gagal login
$routes->get('/login','Admin::index');

// dijalankan saat menekan tombol login
$routes->post('/login','Admin::login');

// membuat route untuk user yang sukes login
$routes->get('/dashboard','Dashboardpengguna::index',['filter'=>'otentifikasi']);

// membuat logout 
$routes->get('/logout','Admin::index');

############### RUTE untuk mengelola Fasilitas Hotel #####################

$routes->get('/fasilitas-hotel','Fasilitashotel::index',['filter'=>'otentifikasi']);

$routes->get('/tambah-fasilitas-hotel','Fasilitashotel::tambah',['filter'=>'otentifikasi']);

$routes->post('/tambah-fasilitas-hotel','Fasilitashotel::tambah',['filter'=>'otentifikasi']);

$routes->get('/hapus-fasilitas-hotel/(:num)','Fasilitashotel::hapus/$1',['filter'=>'otentifikasi']);

$routes->get('/edit-fasilitas-hotel/(:num)','Fasilitashotel::edit/$1',['filter'=>'otentifikasi']);

$routes->post('/edit-fasilitas-hotel','Fasilitashotel::edit',['filter'=>'otentifikasi']);

############### RUTE untuk mengelola Fasilitas Kamar #####################

$routes->get('/fasilitas-kamar','Fasilitaskamar::index',['filter'=>'otentifikasi']);

$routes->get('/tambah-fasilitas-kamar','Fasilitaskamar::tambah',['filter'=>'otentifikasi']);

$routes->post('/tambah-fasilitas-kamar','Fasilitaskamar::tambah',['filter'=>'otentifikasi']);

$routes->get('/hapus-fasilitas-kamar/(:num)','Fasilitaskamar::hapus/$1',['filter'=>'otentifikasi']);

$routes->get('/edit-fasilitas-kamar/(:num)','Fasilitaskamar::edit/$1',['filter'=>'otentifikasi']);

$routes->post('/edit-fasilitas-kamar','Fasilitaskamar::edit',['filter'=>'otentifikasi']);


############### RUTE untuk mengelola Fasilitas Kamar #####################

$routes->get('/tampil-kamar','Kamar::index',['filter'=>'otentifikasi']);

$routes->get('/tambah-kamar','Kamar::tambah',['filter'=>'otentifikasi']);

$routes->post('/tambah-kamar','Kamar::tambah',['filter'=>'otentifikasi']);

$routes->get('/hapus-kamar/(:num)','Kamar::hapus/$1',['filter'=>'otentifikasi']);

$routes->get('/edit-kamar/(:num)','Kamar::edit/$1',['filter'=>'otentifikasi']);

$routes->post('/edit-kamar','Kamar::edit',['filter'=>'otentifikasi']);

$routes->get('/hapus-item-fasilitas-kamar/(:num)','Kamar::hapusItemFasilitas/$1',['filter'=>'otentifikasi']);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
