<?php
//tester si logué... sinon, redirigé vers la bonne page
$login  = new login();
if(!$login->verifConnexion() OR !$login->testDroit('admin'))
  header('Location: '.$config['baseDir'].'/login');

if(isset($_GET['action']) AND $_GET['action'] == 'aprob')
{
        $prob = new problemes();
        $prob->prob_niveau($_GET['id'], $_GET['id_type'], $_GET['gravite'], -1);
        header('Location: '.$config['baseDir'].'/admin');
}


include($config['tplServer'].'/admin.tpl');
?>
