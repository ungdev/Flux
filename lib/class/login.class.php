<?php

/*
 *
 * Auteur : Reivax <bernard.xav@gmail.com>
 * Modification : 21/04/09 par ReivaX
 *
 * Description : Fonctions relatives à la connexion d'un utilisateur
 *
 */

class login
{
    private $sql;

    public function __construct()
    {
        $this->sql = new SQL();
    }

  // on vérifie si le couple login / mot de passe existe
  public function verifForm($utilisateur, $pass)
  {
      $resultat = $this->sql->select('id, login', 'utilisateur', "WHERE login='".$utilisateur."' AND pass='".SHA1($pass)."'");
      if ($resultat) {
          $_SESSION['id'] = $resultat['id'];
          $_SESSION['login'] = $resultat['login'];
          $this->ajouterDroits($utilisateur);

          return 1;
      } else {
          return 0;
      }
  }

  //on ajoute les droits de l'utilisateur dans un tableau stocké dans $_SESSION['droit']
  public function ajouterDroits($utilisateur)
  {
      $id = $_SESSION['id'];
      $resultat = $this->sql->select('droit.id, nom', 'droit', "INNER JOIN liste_droit ON (liste_droit.id_droit=droit.id) WHERE liste_droit.id_utilisateur='".$id."'");

    //si y a aucun droit
    if (!$resultat) {
        return 0;
    }

    //si un seul droit, on a un tableau simple
    $droits = array();
      $id_droits = array();
      if (array_key_exists('nom', $resultat)) {
          $droits[] = $resultat['nom'];
          $id_droits[] = $resultat['id'];
      }
    //sinon, tableau double
    else {
        foreach ($resultat as $value) {
            $droits[] = $value['nom'];
            $id_droits[] = $value['id'];
        }
    }
      $_SESSION['droit'] = $droits;
      $_SESSION['id_droit'] = $id_droits;
  }

    public function droitEspace()
    {
        $id = $_SESSION['id'];
        $resultat = $this->sql->select('id, nom', 'espace', "WHERE etat='1' AND id_utilisateur='".$id."'");

        if ($resultat) {
            $_SESSION['id_espace'] = $resultat['id'];
            $_SESSION['nom_espace'] = $resultat['nom'];

            return 1;
        } else {
            return 0;
        }
    }

  //test si l'utilisateur connecté a le droit donné en paramètre
  public function testDroit($droit)
  {
      if (@in_array($droit, $_SESSION['droit'])) {
          return 1;
      } else {
          return 0;
      }
  }

  //test si il est connecté
  public function verifConnexion()
  {
      if (isset($_SESSION['id']) and is_numeric($_SESSION['id']) and isset($_SESSION['login'])) {
          return 1;
      } else {
          return 0;
      }
  }

  // deconnexion...
  public function deconnexion()
  {
      session_destroy();
  }

    public function __destruct()
    {
        mysql_close();
    }
}
