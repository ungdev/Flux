<?php
session_start();

// Avoid some kind of LFI.
if (isset($_GET['page'])) {
	if (strpos($_GET['page'], '..') !== false) {
	    header('HTTP/1.0 403 Forbidden');
	    die();
	}
}

/*if (!function_exists('mysql_query')) {
  die('Version de PHP non-compatible avec mysql_*');
}*/

require_once 'lib/conf/config.php';

function __autoload($className) {
    global $config;
    require_once $config['libServer'].'/class/'.$className.'.class.php';
}

if(isset($_GET['page'])) {
	if(file_exists($config['libServer'].'/action/'.$_GET['page'].'.php')) {
	    require_once $config['libServer'].'/action/'.$_GET['page'].'.php';
	} else {
	    require_once $config['libServer'].'/action/login.php';
	}
} else {
	require_once $config['libServer'].'/action/login.php';
}
