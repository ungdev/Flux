<?php
/*
 * 
 * Auteur : SoX <flosox@gmail.com>
 * Modification : 09/05/09 par SoX
 * 
 * Description : Actions effectués sur les flux
 * 
 */
 
//tester si droit
$login  = new login();
if(!$login->verifConnexion())
  header('Location: '.$config['baseDir'].'/manque_droit'); 
 
$flux = new flux();

$flux->liste($_SESSION['id_espace']);

unset($flux);

?>
