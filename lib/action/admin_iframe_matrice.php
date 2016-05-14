<?php
//tester si logué... sinon, redirigé vers la bonne page
/*$login  = new login();
if(!$login->verifConnexion())
  header('Location: /login');*/
$login  = new login();
if(!$login->verifConnexion() OR (!$login->testDroit('matrice') AND !$login->testDroit('superadmin')))
  header('Location: '.$config['baseDir'].'/manque_droit');


$admin = new admin_iframe_matrice();

if(isset($_GET['action']) AND $_GET['action'] == 'table_stock')
{
	if(isset($_GET['id_stock'])){
		$admin->table_stock($_GET['id_stock']);
	}
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'bouger_stock')
{
	$admin->tr_stock($_GET['id_stock'], $_GET['id_espace']);	
}
else
{
	include($config['tplServer'].'/admin_iframe_matrice.tpl');
}

?>
