<?php
//tester si droit
$login  = new Login();
if(!$login->isConnected() OR !($login->testDroit('superadmin') OR $login->testDroit('treso')))
  header('Location: '.$config['baseDir'].'/manque_droit');
  
?>

<iframe id="iframe_admin" class="iframe_admin" src="admin_iframe_treso" width="100%" height="500"></iframe>
