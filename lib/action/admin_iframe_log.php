<?php
//tester si logué... sinon, redirigé vers la bonne page
/*$login  = new Login();
if(!$login->isConnected())
  header('Location: /login');*/
$login  = new Login();
if(!$login->isConnected() OR (!$login->testDroit('logistique') AND !$login->testDroit('superadmin')))
  header('Location: '.$config['baseDir'].'/manque_droit');



$admin = new admin_iframe_log();

if(isset($_GET['action']) AND $_GET['action'] == 'table_stock')
{
	if(isset($_GET['id_stock'])){
		$admin->table_stock('stock', $_GET['id_stock']);
	} else {
		$admin->table_stock('espace', $_GET['id_espace']);
	}
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'bouger_stock')
{
	$admin->tr_stock($_GET['id_stock'], $_GET['id_espace']);	
}
else
{
	include($config['tplServer'].'/admin_iframe_log.tpl');
}
?>
