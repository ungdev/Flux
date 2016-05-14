<?php
/*
 * 
 * Auteur : SoX <flosox@gmail.com>
 * Modification : 11/05/09 par SoX
 * 
 * Description : Appel du contenu de l'onglet Probleme de l'administration
 * 
 */
 
//tester si droit
$login  = new login();
if(!$login->verifConnexion() OR !$login->testDroit('admin'))
  header('Location: '.$config['baseDir'].'/manque_droit');
 
$admin_problemes = new admin_problemes();

if(isset($_POST['auteur']))
{
	$admin_problemes->enregistrerAuteur($_POST['id'], $_POST['auteur']);
}
else
	$admin_problemes->liste();

unset($admin_problemes);

?>
