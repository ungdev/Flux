<?php
//tester si droit
$login  = new Login();
if(!$login->isConnected() OR !$login->testDroit('admin'))
  header('Location: '.$config['baseDir'].'/manque_droit');
?>

<iframe id="iframe_admin" class="iframe_admin" src="admin_iframe_matrice" width="100%" height="500"></iframe>
