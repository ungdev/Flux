<?php

namespace lib;

/**
 * Login methods.
 *
 */
class Login
{
    private $sql;

    public function __construct()
    {
        $this->sql = new SQL();
    }

    /**
     * Vérification des identifiants de l'utilisateur.
     *
     * @param  string $user
     * @param  string $pass
     * @return bool
     */
    public function checkCredentials($user, $pass)
    {
        if (!ctype_alnum($user)) {
            die('Symboles non-autorisés dans le nom d\'utilisateur.');
        }

        $resultat = $this->sql->select('id, login', 'utilisateur', "WHERE login='".$user."' AND pass='".SHA1($pass)."'");
        if ($resultat) {
            $_SESSION['id'] = $resultat['id'];
            $_SESSION['login'] = $resultat['login'];
            $this->ajouterDroits($user);
            return true;
        }
        return false;
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

    /**
     * Est-ce que l'utilisateur est connecté ?
     *
     * @return bool
     */
    public function isConnected()
    {
        if (isset($_SESSION['id']) && is_numeric($_SESSION['id']) && isset($_SESSION['login'])) {
            return true;
        }
        return false;
    }
}
