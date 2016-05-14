<?php
$login  = new login();
$login->deconnexion();

header('Location: '.$config['baseDir'].'/');
?>
