<?php

$login = new Login();

// L'utilisateur vient de soumettre le formulaire, on vérifie s'il n'est pas
// déjà connecté ou si
if (array_key_exists('utilisateur', $_POST) && array_key_exists('password', $_POST)) {
    if ($login->isConnected() || $login->checkCredentials($_POST['utilisateur'], $_POST['password'])) {
        // Redirection vers la bonne page en fonction de ses droits.
        if ($login->testDroit('admin')) {
            header('Location: '.$config['baseDir'].'/admin');
        } elseif ($login->droitEspace()) {
          header('Location: '.$config['baseDir'].'/espace');
        } else {
            die('Ce compte n\'a aucun droit !');
        }
    }
}

// Sinon, c'est qu'on vient d'arriver sur la page dans le but de se connecter.
require_once $config['tplServer'].'/login.tpl';
