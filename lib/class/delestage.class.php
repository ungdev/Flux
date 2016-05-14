<?php
/*
 *
 * Auteur : SoX <flosox@gmail.com>
 * Modification : 08/05/09 par SoX
 *
 * Description : Gestion des délestages
 *
 */

 class delestage
 {
    private $sql;

    // Le constructeur ouvre la connexion sql
    public function __construct()
    {
        $this->sql = new SQL();
    }

    // Le destruction ferme la connexion sql
    public function __destruct()
    {
        unset($this->sql);
    }

    public function form()
    {
     ?>
        <form method="post" action="?action=delestage">
        <input type="text" name="login_delestage" value="Login" onfocus="if(this.value=='Login'){this.value=''};" onBlur="if(this.value==''){this.value='Login'};" />
        <input type="password" name="password_delestage" value="Mot de passe" onfocus="if(this.value=='Mot de passe'){this.value=''};" onBlur="if(this.value==''){this.value='Mot de passe'};" />
        <input type="text" name="nb_jetons" value="Nombre de jetons" onfocus="if(this.value=='Nombre de jetons'){this.value=''};" onBlur="if(this.value==''){this.value='Nombre de jetons'};" />
        <input id="submit_form_delestage" type="submit" value="Envoyer" />
        </form>
    <?php

    }

    public function traite_form($login_delestage, $password, $nb_jetons)
    {
        if (isset($login_delestage)) {
            $resultat = $this->sql->select('utilisateur.id, utilisateur.pass, droit.nom as droit, nom', 'utilisateur', 'INNER JOIN liste_droit ON (liste_droit.id_utilisateur=utilisateur.id) INNER JOIN droit ON (liste_droit.id_droit=droit.id) WHERE utilisateur.login=\''.$login_delestage.'\'');
            if (sha1($password) === $resultat['pass']) {
                // Si droit delestage, on déleste :)
        if ($resultat['droit'] === 'delestage') {
           if (is_numeric($nb_jetons)) {
               $this->sql->insert('delestage', '`id_espace`, `somme`, `heure`, `id_utilisateur`', $_SESSION['id_espace'].','.$nb_jetons.', NOW( ), '.$resultat['id']);
               echo '<script>alert("Délestage de '.$nb_jetons.' UTs ! ")</script>';
           } else {
               echo "<script>alert(\"Le nombre de jeton inscrit n'est pas un nombre ! \")</script>";
           }
        } else {
           echo "<script>alert(\"Vous n'avez pas les droits pour délester ! \")</script>";
        }
            } else {
                echo "<script>alert(\"Nom d'utilisateur ou mot de passe incorrect\")</script>";
            }
        }
        echo '<script language="javascript" type="text/javascript">
         <!--
         window.location.replace("/espace");
         -->
         </script>';
    }
 }
