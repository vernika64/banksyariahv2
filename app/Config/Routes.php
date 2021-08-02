<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Cpanel');
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

// Setup Pertama kali
$routes->get('setup', 'Cpanel::setup');
$routes->post('daftarbank', 'Cpanel::install');

// Rute Website
$cln = ['filter' => 'ceklogin'];
$cekb = ['filter'	=> 'cekdatabank'];

$routes->get('/', 'Cpanel::index', $cekb);
$routes->post('masuk', 'Cpanel::proses');
$routes->get('dashboard', 'Cpanel::dashboard', $cln);
$routes->get('cif', 'Cpanel::cif', $cln);
$routes->get('karyawan', 'Cpanel::karyawanz', $cln);

// Rute CS

// Sub Rute CS - CIF
$routes->get('regcif', 'Cpanel::buatcif', $cln);
$routes->post('procif', 'Cpanel::daftarcif');
// Sub Rute CS - Rekening Wadiah
$routes->get('registrasirek', 'Cpanel::regrek');
$routes->post('registrasirek', 'Cpanel::regrek');
$routes->post('prosesbuatrek', 'Cpanel::buattab');


// Rute Teller
$routes->get('tt', 'Cpanel::tariktunai', $cln); // Link Tarik Tunai
$routes->post('tt', 'Cpanel::tariktunai', $cln); // Link Post Tarik Tunai
$routes->post('ptt', 'Cpanel::prosestt', $cln); // Link Post Tarik Tunai

$routes->get('tr', 'Cpanel::transfer', $cln); // Link Setor Tunai
$routes->post('tr', 'Cpanel::transfer', $cln); // Link Input Setor Tunai

// Rute SPV
$routes->get('bksetortunai', 'Cpanel::cekbktransfer', $cln); // Link Tarik Tunai

// Pemrosesan Data
$routes->post('dafkar', 'Cpanel::buatKaryawan', $cln);



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
