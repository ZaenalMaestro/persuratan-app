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
$routes->get('/login', 'Login::index', ['filter' => 'login']);
$routes->post('/login', 'Login::signIn', ['filter' => 'login']);
$routes->get('/logout', 'Login::logOut');

// portal LP2M
$routes->get('/', 'Portal\PortalLP2M::index');

// admin
$routes->group('admin', ['filter' => 'admin'], function($routes)
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
	$routes->get('surat-masuk/print', 'Admin\SuratMasuk::printSurat');
	$routes->get('surat-masuk/lihat/(:num)', 'Admin\SuratMasuk::lihat/$1');
	$routes->get('surat-masuk/(:num)', 'Admin\SuratMasuk::edit/$1');

	// surat keluar
	$routes->get('surat-keluar', 'Admin\SuratKeluar::index');
	$routes->post('surat-keluar', 'Admin\SuratKeluar::create');
	$routes->post('surat-keluar/upload', 'Admin\SuratKeluar::upload');
	$routes->put('surat-keluar', 'Admin\SuratKeluar::update');
	$routes->get('surat-keluar/insert', 'Admin\SuratKeluar::insert');
	$routes->delete('surat-keluar', 'Admin\SuratKeluar::destroy');
	$routes->get('surat-keluar/print', 'Admin\SuratKeluar::printSurat');
	$routes->get('surat-keluar/download/(:num)', 'Admin\SuratKeluar::download/$1');
	$routes->get('surat-keluar/lihat/(:num)', 'Admin\SuratKeluar::lihat/$1');
	$routes->get('surat-keluar/(:num)', 'Admin\SuratKeluar::edit/$1');

	// penerima surat
	$routes->get('penerima-surat', 'Admin\PenerimaSurat::index');
	$routes->post('penerima-surat', 'Admin\PenerimaSurat::create');
	$routes->delete('penerima-surat', 'Admin\PenerimaSurat::destroy');
	$routes->put('penerima-surat', 'Admin\PenerimaSurat::update');

	// template surat
	$routes->get('template', 'Admin\TemplateSurat::index');
	$routes->get('template/all', 'Admin\TemplateSurat::allTemplate');
	$routes->deLete('template', 'Admin\TemplateSurat::destroy');
	$routes->get('template/create', 'Admin\TemplateSurat::create');
	$routes->post('template/insert', 'Admin\TemplateSurat::insert');
	$routes->get('template/edit/(:num)', 'Admin\TemplateSurat::edit/$1');
	$routes->put('template/update', 'Admin\TemplateSurat::update');	
	$routes->get('surat-keluar/detail/(:num)', 'Ketua\SuratKeluar::detail/$1');

	// ganti password
	$routes->get('password', 'Admin\AkunAdmin::index');
	$routes->put('password/update', 'Admin\AkunAdmin::update');
});

// Sskertaris
$routes->group('sekertaris', ['filter' => 'sekertaris'], function($routes)
{
	// dashboard
	$routes->get('/', 'Sekertaris\Dashboard::index');	
	$routes->post('/', 'Sekertaris\Dashboard::disposisi');	

	// surat masuk
	$routes->get('surat-masuk', 'Sekertaris\SuratMasuk::index');
	$routes->post('surat-masuk', 'Sekertaris\SuratMasuk::create');
	$routes->put('surat-masuk', 'Sekertaris\SuratMasuk::update');
	$routes->get('surat-masuk/lihat/(:num)', 'Sekertaris\SuratMasuk::lihat/$1');
	$routes->get('surat-masuk/insert', 'Sekertaris\SuratMasuk::insert');
	$routes->delete('surat-masuk', 'Sekertaris\SuratMasuk::destroy');
	$routes->get('surat-masuk/print', 'Sekertaris\SuratMasuk::printSurat');
	$routes->get('surat-masuk/(:num)', 'Sekertaris\SuratMasuk::edit/$1');

	// surat keluar
	$routes->get('surat-keluar', 'Sekertaris\SuratKeluar::index');
	$routes->post('surat-keluar', 'Sekertaris\SuratKeluar::create');
	$routes->put('surat-keluar', 'Sekertaris\SuratKeluar::update');
	$routes->get('surat-keluar/insert', 'Sekertaris\SuratKeluar::insert');
	$routes->delete('surat-keluar', 'Sekertaris\SuratKeluar::destroy');
	$routes->get('surat-keluar/print', 'Sekertaris\SuratKeluar::printSurat');
	$routes->get('surat-keluar/(:num)', 'Sekertaris\SuratKeluar::edit/$1');
	$routes->put('surat-keluar/komentar', 'Sekertaris\SuratKeluar::tambahKomentar');
	$routes->put('surat-keluar/terima', 'Sekertaris\SuratKeluar::terimaSurat');

	// ganti password
	$routes->get('password', 'Sekertaris\AkunAdmin::index');
	$routes->put('password/update', 'Sekertaris\AkunAdmin::update');
});

// ketua
$routes->group('ketua', ['filter' => 'ketua'], function($routes)
{
	// dashboard
	$routes->get('/', 'Ketua\Dashboard::index');
	$routes->post('/', 'Ketua\Dashboard::disposisi');
	$routes->get('data_surat', 'Ketua\DataSurat::index');
	$routes->get('detail/(:num)', 'Ketua\Dashboard::show/$1');

	// surat masuk
	$routes->get('surat-masuk', 'Ketua\SuratMasuk::index');
	$routes->get('surat-masuk/print', 'Ketua\SuratMasuk::printSurat');
	$routes->get('surat-masuk/lihat/(:num)', 'Ketua\SuratMasuk::lihat/$1');

	// surat keluar
	$routes->get('surat-keluar', 'Ketua\SuratKeluar::index');
	$routes->get('surat-keluar/print', 'Ketua\SuratKeluar::printSurat');	
	$routes->get('surat-keluar/download/(:num)', 'Ketua\SuratKeluar::download/$1');
	$routes->get('surat-keluar/lihat/(:num)', 'Ketua\SuratKeluar::lihat/$1');
	$routes->get('surat-keluar/detail/(:num)', 'Ketua\SuratKeluar::detail/$1');

	// ganti password
	$routes->get('password', 'Ketua\AkunAdmin::index');
	$routes->put('password/update', 'Ketua\AkunAdmin::update');
});

// kepala
$routes->group('kepala', ['filter' => 'kepala'], function($routes)
{
	// dashboard
	$routes->get('/', 'Kepala\Dashboard::index');
	$routes->get('data_surat', 'Kepala\DataSurat::index');
	
	$routes->get('surat-masuk/lihat/(:num)', 'Ketua\SuratMasuk::lihat/$1');
	$routes->get('detail/(:num)', 'Kepala\Dashboard::show/$1');

	// ganti password
	$routes->get('password', 'Kepala\AkunAdmin::index');
	$routes->put('password/update', 'Kepala\AkunAdmin::update');
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
