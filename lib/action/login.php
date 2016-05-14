<?php

$login  = new login();

//si on vient du formulaire
if((isset($_POST['utilisateur']) AND ($login->verifForm($_POST['utilisateur'], $_POST['password']))) OR $login->verifConnexion())
{
  //si droit admin, on l'envoie sur l'admin :)
  if($login->testDroit('admin'))
  {
    header('Location: '.$config['baseDir'].'/admin');	  
  }
  //sinon, on check si il a un EAT
  elseif($login->droitEspace())
  {
    header('Location: '.$config['baseDir'].'/espace');
  }
  //aucun droit... désolé
  else
  {
    //mettre la page erreur à la place si bugue qu'on comprend pas :)
	header('Location: '.$config['baseDir'].'/deconnexion');
  } 
}

unset($login);

//si pas valide ou si l'on vient d'arriver sur la page
include($config['tplServer'].'/login.tpl');
?>
