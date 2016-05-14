<?php

/*
 *
 *  Auteur : Theo <theophile.gurliat@gmail.com> le 15/05/2011
 *
 * Description :
 *
 */

class admin_iframe_treso
{
    private $sql;
    private $timeCourant;

    public function __construct()
    {
        $this->sql = new SQL();
        $this->timeCourant = time();
    }

    public function afficher_delestage()
    {
        $resulat = $this->sql->select('delestage.id as id, delestage.somme, espace.nom, utilisateur.login, delestage.heure ', 'delestage, espace, utilisateur', ' where delestage.id_utilisateur=utilisateur.id  and espace.id=delestage.id_espace order by delestage.id DESC');

        echo '<table width=100%>';
        echo '<tr>';
        echo '<td>EAT</td>';
        echo '<td>SOMME</td>';
        echo '<td>DELESTEUR</td>';
        echo '<td>HEURE</td>';
        echo '</tr>';
        foreach ($resulat as $value) {
            echo '<tr>';
            echo '<td>'.$value['nom'].'</td>';
            echo '<td>'.$value['somme'].'</td>';
            echo '<td>'.$value['login'].'</td>';
            echo '<td>'.$value['heure'].'</td>';

            echo '</tr>';
        }

        echo '</table>';

   // $this->sql->insert('delestage', '`id_espace`, `somme`, `heure`, `id_utilisateur`', $_SESSION['id_espace'].','.$nb_jetons.', NOW( ), '.$resultat['id']);
    }
}
