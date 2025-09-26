<?php namespace Config;
      use App\Controllers\RestResume;

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
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('home');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Home Page
$routes->get('/', 'HomePageController::index');
$routes->get('/about', 'HomePageController::about');
$routes->get('/knowthebusiness', 'HomePageController::knowthebusiness');
$routes->get('/knowthebusiness/simulation', 'HomePageController::knowthebusiness_simulation');
$routes->get('/blog', 'HomePageController::blog');
$routes->get('/blog/(:num)', 'HomePageController::blog_detail/$1');
$routes->get('/testimonials', 'HomePageController::testimonials');
$routes->get('/galery', 'HomePageController::galery');





$routes->get('/chat', 'PruebaController::chat');
$routes->get('/datatable/(:segment)', 'PruebaController::datatable/$1');

$routes->post('/table', 'PruebaController::table');
$routes->get('/table', 'PruebaController::table');

$routes->post('prueba', 'PruebaController::index');

$routes->get('password', 'PasswordController::index');
$routes->post('password/updated', 'PasswordController::updated');

$routes->group('dashboard', function ($routes){
	$routes->get('', 'DashboardController::index');

	$routes->group('movements', function($routes){
		$routes->get('(:segment)', 'Sistem\MovementsController::index/$1');
		$routes->get('data/(:segment)', 'Sistem\MovementsController::data/$1');
		$routes->post('save', 'Sistem\MovementsController::save');
		$routes->put('save/(:num)', 'Sistem\MovementsController::update/$1');
		$routes->delete('save/(:num)', 'Sistem\MovementsController::decline/$1');
		$routes->get('contract/(:num)', 'Sistem\MovementsController::contract/$1');
		$routes->post('(:num)/indicadores', 'Sistem\MovementsController::indicadores/$1');
	});

	$routes->group('projects', function($routes){
		$routes->get('', 'Sistem\ProjectController::index');
		$routes->get('data', 'Sistem\ProjectController::data');
		$routes->post('save', 'Sistem\ProjectController::save');
		$routes->get('kardex/(:num)', 'Sistem\ProjectController::kardex/$1');
		$routes->post('indicadores', 'Sistem\ProjectController::indicadores');
	});
});

$routes->get('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/create', 'AuthController::create');
$routes->get('/reset_password', 'AuthController::resetPassword');
$routes->post('/forgot_password', 'AuthController::forgotPassword');
$routes->post('/validation', 'AuthController::validation');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/about', 'DashboardController::about');
$routes->get('/perfile', 'UserController::perfile');
$routes->post('/update_photo', 'UserController::updatePhoto');
$routes->post('/update_user', 'UserController::updateUser');
$routes->post('/config/(:segment)', 'ConfigController::index/$1');
$routes->get('/config/(:segment)', 'ConfigController::index/$1');
$routes->post('/table/(:segment)', 'TableController::index/$1');
$routes->get('/table/(:segment)', 'TableController::index/$1');

$routes->post('/table/(:segment)/(:segment)', 'TableController::detail/$1/$2');
$routes->get('/table/(:segment)/(:segment)', 'TableController::detail/$1/$2');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
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
