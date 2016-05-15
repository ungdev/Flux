<?php
use lib\Login;

session_start();

// Load configuration
require_once '../config/config.php';

// Class autoloading
function __autoload($className) {
	global $conf;
	$className = str_replace('\\', '/', $className);
	require_once $conf['server_path'].$className.'.php';
}

// Router
require_once '../config/routes.php';
$uri = explode('?', $_SERVER['REQUEST_URI'])[0];
$selectedRoute = false;
if (isset($route[$uri])) {
	$selectedRoute = $route[$uri];
}

// Execute controller
$data = [];
if($selectedRoute && isset($selectedRoute['controller']) && isset($selectedRoute['action'])) {
	$classname = '\controllers\\'.$selectedRoute['controller'].'Controller';
	$actionname = $selectedRoute['action'].'Action';

	$controller = new $classname();
	$data = $controller->$actionname();
}

// Redirect if asked
if(isset($data['redirection'])) {
	header('Location: '.$conf['web_uri'].$data['redirection']);
	exit;
}

// Print view
function execTemplate($view, $layout, $vars) {
	global $conf;
	$login = new Login;

	// Print view
	ob_start();
	require $conf['server_path'].'views/'.$view.'.php';
	$content = ob_get_clean();

	// Print template
	ob_start();
	require $conf['server_path'].'views/layouts/'.$layout.'.php';
	return ob_get_clean();
}

$data['layout'] = (!empty($data['layout']))?$data['layout']:'default';
$data['view'] = (!empty($data['view']))?$data['view']:'errors/404';
$data['vars'] = (!empty($data['vars']))?$data['vars']:[];

echo execTemplate($data['view'], $data['layout'], $data['vars']);
