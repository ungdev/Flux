<?php
//tester si logué... sinon, redirigé vers la bonne page
/*$login  = new Login();
if(!$login->isConnected())
  header('Location: /login');*/
$login  = new Login();
if(!$login->isConnected() OR (!$login->testDroit('treso') AND !$login->testDroit('superadmin')))
  header('Location: '.$config['baseDir'].'/manque_droit');
 

$admin = new admin_iframe_treso();

$admin->afficher_delestage();


?>
