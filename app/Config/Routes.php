<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// login
$routes->get('/', 'Login::index', ['filter' => 'isLogin']);
// $routes->post('/login', 'Login::signIn', ['filter' => 'isLogin']);
// $routes->get('/logout', 'Login::logOut');

// admin
$routes->group('admin', function($routes)
{
	// dashboard
	$routes->get('/', 'Admin\Dashboard::index');	
	$routes->post('/', 'Admin\Dashboard::disposisi');	

	// surat masuk
	$routes->get('surat-masuk', 'Admin\SuratMasuk::index');
	$routes->post('surat-masuk', 'Admin\SuratMasuk::create');
	$routes->put('surat-masuk', 'Admin\SuratMasuk::update');
	$routes->get('surat-masuk/insert', 'Admin\SuratMasuk::insert');
	$routes->delete('surat-masuk', 'Admin\SuratMasuk::destroy');
	$routes->get('surat-masuk/(:any)', 'Admin\SuratMasuk::edit');

	// surat keluar
	$routes->get('surat-keluar', 'Admin\SuratKeluar::index');
	$routes->post('surat-keluar', 'Admin\SuratKeluar::create');
	$routes->put('surat-keluar', 'Admin\SuratKeluar::update');
	$routes->get('surat-keluar/insert', 'Admin\SuratKeluar::insert');
	$routes->delete('surat-keluar', 'Admin\SuratKeluar::destroy');
	$routes->get('surat-keluar/(:any)', 'Admin\SuratKeluar::edit');

	// penerima surat
	$routes->get('penerima-surat', 'Admin\PenerimaSurat::index');
	$routes->post('penerima-surat', 'Admin\PenerimaSurat::create');
	$routes->delete('penerima-surat', 'Admin\PenerimaSurat::destroy');
});



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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
