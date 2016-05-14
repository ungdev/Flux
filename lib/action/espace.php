<?php
//tester si logué... sinon, redirigé vers la bonne page
$login  = new login();
if(!$login->verifConnexion())
  header('Location: '.$config['baseDir'].'/login');

if(isset($_GET['action']) AND $_GET['action'] == 'prob') 
{
	$prob = new problemes();
	$prob->prob_niveau($_POST['id'], $_POST['id_type'], $_POST['gravite'], 1);
	header('Location: '.$config['baseDir'].'/espace');
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'aprob') 
{
	$prob = new problemes();
	$prob->prob_niveau($_GET['id'], $_GET['id_type'], $_GET['gravite'], -1);
	header('Location: '.$config['baseDir'].'/espace');
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'flux') 
{
	$flux = new flux();
	$flux->stock_niveau($_POST['id_stock'],$_POST['id_espace'], 1);
	header('Location: '.$config['baseDir'].'/espace');
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'aflux') 
{
	$flux = new flux();
	$flux->stock_niveau($_GET['id'],$_GET['id_espace'], -1);
	header('Location: '.$config['baseDir'].'/espace');
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'delestage')
{
	$delestage = new delestage();
	$delestage->traite_form($_POST['login_delestage'], $_POST['password_delestage'], $_POST['nb_jetons']);
}
include($config['tplServer'].'/espace.tpl');
?>
