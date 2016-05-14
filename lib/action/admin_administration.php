<?php
//tester si droit
$login  = new Login();
if(!$login->isConnected() OR !$login->testDroit('admin'))
  header('Location: '.$config['baseDir'].'/manque_droit');
/*
 * 
 * Auteur : SoX <flosox@gmail.com>
 * Modification : 09/05/09 par SoX
 * 
 * Description : Appel du contenu de l'onglet d'administration
 * 
 */
 
$admin = new admin_administration();

if(isset($_POST['login']))
{
	//on enregistre
	$admin->enregistrer_utilisateur($_POST['login'], $_POST['password'], $_POST['droit']);
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'liste_utilisateurs')
{
	$admin->liste_utilisateurs();
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'liste_supprimer_utilisateur')
{
	$admin->liste_supprimer_utilisateur($_GET['id']);
}
else
	include($config['tplServer'].'/admin_administration.tpl');
?>
