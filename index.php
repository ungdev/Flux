<?php
session_start();

// Avoid some kind of LFI.
if (strpos($_GET['page'], '..') !== false) {
    header('HTTP/1.0 403 Forbidden');
    die();
}

require_once 'lib/conf/config.php';

function __autoload($className) {
    global $config;
    require_once $config['libServer'].'/class/'.$className.'.class';
}

if(file_exists($config['libServer'].'/action/'.$_GET['page'].'.php')) {
    require_once $config['libServer'].'/action/'.$_GET['page'].'.php';
} else {
    require_once $config['libServer'].'/action/login.php';
}
