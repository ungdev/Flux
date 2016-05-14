<?php
/*
 * 
 * Auteur : SoX <flosox@gmail.com>
 * Modification : 13/05/09 par SoX
 * 
 * Description : Historique complet des EàT
 * 
 */

//tester si droit
/*$login  = new Login();
if(!$login->isConnected())
  header('Location: /manque_droit');*/

$login  = new Login();
if(!$login->isConnected() OR !$login->testDroit('superadmin'))
  header('Location: '.$config['baseDir'].'/manque_droit');


$histobar = new histobar();

$histobar->class_que_tu_veux();

 
include($config['tplServer'].'/histobar.tpl');

unset($histobar);
?>
