<?php
session_start();

include('lib/conf/config_secure.inc');

function __autoload($class_name) {
  global $config;
  include_once($config['libServer'].'/class/'.$class_name.'.class');
}

if(file_exists($config['libServer'].'/action/'.$_GET['page'].'.php'))
	include_once($config['libServer'].'/action/'.$_GET['page'].'.php');
else
	include_once($config['libServer'].'/action/login.php');
?>