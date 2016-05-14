<?php
/*
 * 
 * Auteur : SoX <flosox@gmail.com>
 * Modification : 27/04/09 par SoX
 * 
 * Description : Actions effectués pour la colonne Problèmes
 * 
 */
//tester si droit
$login  = new login();
if(!$login->verifConnexion())
  header('Location: '.$config['baseDir'].'/manque_droit');
 
$problemes = new problemes();

$problemes->liste();

unset($problemes);

?>
