<?php

namespace lib;

/*
 *
 * Auteur : Reivax <bernard.xav@gmail.com>
 * Modification : 15/05/11 par SoX <flosox@gmail.com>
 *
 * Description :
 *
 */

class admin_iframe_log
{
    private $sql;
    private $timeCourant;

    public function __construct()
    {
        $this->sql = new SQL();
        $this->timeCourant = time();
    }

    public function retourneSelectTypeStock($valueEx = '')
    {
        $resulat = $this->sql->select('id, nom', 'type_stock', 'ORDER BY nom');
        $string = '<option value="">choix du stock</option>';
        foreach ($resulat as $value) {
            if ($value['id'] == $valueEx) {
                $string .= '<option value="'.$value['id'].'" selected="selected">'.$value['nom'].'</option>';
            } else {
                $string .= '<option value="'.$value['id'].'">'.$value['nom'].'</option>';
            }
        }

        return $string;
    }

    public function retourneSelectEspace($valueEx = '')
    {
        $resulat = $this->sql->select('id, nom, lieu', 'espace', 'ORDER BY nom');
        $string = '<option value="">déplacer vers</option>';
        foreach ($resulat as $value) {
            if ($value['id'] == $valueEx) {
                $string .= '<option value="'.$value['id'].'" selected="selected">'.$value['nom'].' - '.$value['lieu'].'</option>';
            } else {
                $string .= '<option value="'.$value['id'].'">'.$value['nom'].' - '.$value['lieu'].'</option>';
            }
        }

        return $string;
    }

    public function retourneSelectSimulBar($valueEx = '')
    {
        $resulat = $this->sql->select('id, nom, lieu', 'espace', 'ORDER BY nom');
        $string = '<option value="">voir...</option>';
        foreach ($resulat as $value) {
            if ($value['id'] == $valueEx) {
                $string .= '<option value="'.$value['id'].'" selected="selected">'.$value['nom'].' - '.$value['lieu'].'</option>';
            } else {
                $string .= '<option value="'.$value['id'].'">'.$value['nom'].' - '.$value['lieu'].'</option>';
            }
        }

        return $string;
    }

    public function table_stock($type, $id)
    {
        //$resultat = $this->sql->select('stock.id, stock.identifiant, UNIX_TIMESTAMP(stock.entame) as entame, UNIX_TIMESTAMP(stock.fin) as fin, stock.reste, parcours.id_espace, espace.nom, espace.lieu', 'stock', "LEFT JOIN parcours ON (parcours.id_stock = stock.id) LEFT JOIN espace ON (parcours.id_espace = espace.id) WHERE id_type_stock=".$id_type_stock." ORDER BY stock.id");
    //SELECT stock.id, stock.identifiant, UNIX_TIMESTAMP(stock.entame) as entame, UNIX_TIMESTAMP(stock.fin) as fin, stock.reste, parcours.id_espace, espace.nom, espace.lieu FROM stock LEFT JOIN parcours ON (parcours.id_stock = stock.id) LEFT JOIN espace ON (parcours.id_espace = espace.id) WHERE id_type_stock=1 ORDER BY identifiant
    if ($type == 'stock') {
        $resultat = $this->sql->select('stock.id AS id_stock, stock.identifiant, UNIX_TIMESTAMP(stock.entame) as entame, UNIX_TIMESTAMP(stock.fin) as fin, stock.reste, parcours.id_espace, espace.nom, parcours.id AS id_parcours, COUNT(parcours.id) as nbr, espace.lieu, SUBSTR(MAX(CONCAT(LPAD(parcours.id,6,\' \'),espace.nom)),7) as nom_now, SUBSTR(MAX(CONCAT(LPAD(parcours.id,6,\' \'),espace.lieu)),7) as lieu_now', 'stock', 'LEFT JOIN parcours ON (parcours.id_stock = stock.id) LEFT JOIN espace ON (parcours.id_espace = espace.id) WHERE id_type_stock='.$id.' GROUP BY stock.id ORDER BY stock.id');
    //SELECT stock.id, stock.identifiant, UNIX_TIMESTAMP(stock.entame) as entame, UNIX_TIMESTAMP(stock.fin) as fin, stock.reste, parcours.id_espace, espace.nom, parcours.id, MAX(parcours.id), espace.lieu, SUBSTR(MAX(CONCAT(LPAD(parcours.id,6,' '),espace.nom)),7) as nom_now, SUBSTR(MAX(CONCAT(LPAD(parcours.id,6,' '),espace.lieu)),7) as lieu_now FROM stock LEFT JOIN parcours ON (parcours.id_stock = stock.id) LEFT JOIN espace ON (parcours.id_espace = espace.id) WHERE id_type_stock=1 GROUP BY stock.id ORDER BY stock.id
    } else {
        $resultat = $this->sql->select('stock.id AS id_stock, stock.identifiant, UNIX_TIMESTAMP(stock.entame) as entame, UNIX_TIMESTAMP(stock.fin) as fin, stock.reste, parcours.id_espace, espace.nom, parcours.id AS id_parcours, COUNT(parcours.id) as nbr, espace.lieu, SUBSTR(MAX(CONCAT(LPAD(parcours.id,6,\' \'),espace.nom)),7) as nom_now, SUBSTR(MAX(CONCAT(LPAD(parcours.id,6,\' \'),espace.lieu)),7) as lieu_now', 'stock', 'LEFT JOIN parcours ON (parcours.id_stock = stock.id) LEFT JOIN espace ON (parcours.id_espace = espace.id) WHERE espace.id='.$id." AND parcours.fin='0000-00-00 00:00:00' GROUP BY stock.id ORDER BY stock.id");
    }

    //rien
    if ($resultat == 0) {
        echo '<p>aucun stock</p>';
    }
    //un seul
    elseif (isset($resultat['id_stock'])) {
        echo '<table id="tableau_log_fut">';
        echo '<tr>';
        echo '<th>identifiant</th>';
        echo '<th>entamé</th>';
        echo '<th>depuis</th>';
        echo '<th>fini</th>';
        echo '<th>depuis</th>';
        echo '<th>reste</th>';
        echo '<th>bar</th>';
        echo '<th>salle</th>';
        echo '<th>Nbr déplacements</th>';
        echo '<th></th>';
        echo '</tr>';
        echo '<tr id="tr_log_'.$resultat['id_stock'].'"';
        if ($resultat['fin'] != 0) {
            echo ' style="background:red; "';
        } elseif ($resultat['entame'] != 0) {
            echo ' style="background:yellow; "';
        } else {
            echo ' style="background:green; "';
        }
        echo '>';
        echo '<td>'.$resultat['identifiant'].'</td>';
        echo '<td>'.$this->traiteTimestamp($resultat['entame']).'</td>';
        echo '<td>'.$this->depuisTimestamp($resultat['entame']).'</td>';
        echo '<td>'.$this->traiteTimestamp($resultat['fin']).'</td>';
        echo '<td>'.$this->depuisTimestamp($resultat['fin']).'</td>';
        echo '<td>'.$resultat['reste'].'</td>';
        echo '<td>'.$resultat['nom_now'].'</td>';
        echo '<td>'.$resultat['lieu_now'].'</td>';
        echo '<td>'.$resultat['nbr'].'</td>';
        echo '<td><select id="select_espace_'.$resultat['id_stock'].'" class="select_espace_deplace" name="'.$resultat['id_stock'].'">'.$this->retourneSelectEspace().'</select></td>';
        echo '</tr>';
        echo '</table>';
    }
    //plusieurs
    else {
        echo '<table id="tableau_log_fut">';
        echo '<tr>';
        echo '<th>identifiant</th>';
        echo '<th>entamé</th>';
        echo '<th>depuis</th>';
        echo '<th>fini</th>';
        echo '<th>depuis</th>';
        echo '<th>reste</th>';
        echo '<th>bar</th>';
        echo '<th>salle</th>';
        echo '<th>Nbr déplacements</th>';
        echo '<th></th>';
        echo '</tr>';
        foreach ($resultat as $value) {
            echo '<tr id="tr_log_'.$value['id_stock'].'"';
            if ($value['fin'] != 0) {
                echo ' style="background:red; "';
            } elseif ($value['entame'] != 0) {
                echo ' style="background:yellow; "';
            } else {
                echo ' style="background:green; "';
            }
            echo '>';
            echo '<td>'.$value['identifiant'].'</td>';
            echo '<td>'.$this->traiteTimestamp($value['entame']).'</td>';
            echo '<td>'.$this->depuisTimestamp($value['entame']).'</td>';
            echo '<td>'.$this->traiteTimestamp($value['fin']).'</td>';
            echo '<td>'.$this->depuisTimestamp($value['fin']).'</td>';
            echo '<td>'.$value['reste'].'</td>';
            echo '<td>'.$value['nom_now'].'</td>';
            echo '<td>'.$value['lieu_now'].'</td>';
            echo '<td>'.$value['nbr'].'</td>';
            echo '<td><select id="select_espace_'.$value['id_stock'].'" class="select_espace_deplace" name="'.$value['id_stock'].'">'.$this->retourneSelectEspace().'</select></td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    }

    public function tr_stock($id_stock, $id_espace)
    {
        $reste = $this->sql->select('reste', 'stock', "WHERE id='".$id_stock."'");

    //echo $reste[0];
    $this->sql->update('parcours', '`fin` = NOW()', '`id_stock`='.$id_stock.' ORDER BY id DESC LIMIT 1');

        $this->sql->insert('parcours', '`id_stock`, `id_espace`, `debut`, `quantite_debut`', "'".$id_stock."', '".$id_espace."', NOW( ), '".$reste[0]."'");

        $resultat = $this->sql->select('stock.id AS id_stock, stock.identifiant, UNIX_TIMESTAMP(stock.entame) as entame, UNIX_TIMESTAMP(stock.fin) as fin, stock.reste, parcours.id_espace, espace.nom, parcours.id AS id_parcours, COUNT(parcours.id) as nbr, espace.lieu, SUBSTR(MAX(CONCAT(LPAD(parcours.id,6,\' \'),espace.nom)),7) as nom_now, SUBSTR(MAX(CONCAT(LPAD(parcours.id,6,\' \'),espace.lieu)),7) as lieu_now', 'stock', 'LEFT JOIN parcours ON (parcours.id_stock = stock.id) LEFT JOIN espace ON (parcours.id_espace = espace.id) WHERE parcours.id_stock='.$id_stock.' GROUP BY stock.id ORDER BY stock.id');

    //echo '<pre>';
    //print_r($resultat);
    //echo '</pre>';

    $string = '';
        $string .= '<td>'.$resultat['identifiant'].'</td>';
        $string .= '<td>'.$this->traiteTimestamp($resultat['entame']).'</td>';
        $string .= '<td>'.$this->depuisTimestamp($resultat['entame']).'</td>';
        $string .= '<td>'.$this->traiteTimestamp($resultat['fin']).'</td>';
        $string .= '<td>'.$this->depuisTimestamp($resultat['fin']).'</td>';
        $string .= '<td>'.$resultat['reste'].'</td>';
        $string .= '<td>'.$resultat['nom_now'].'</td>';
        $string .= '<td>'.$resultat['lieu_now'].'</td>';
        $string .= '<td>'.$resultat['nbr'].'</td>';
        $string .= '<td>déplacé</td>';

        echo $string;
    }

    private function traiteTimestamp($timestamp)
    {
        if ($timestamp != 0) {
            $string = date('H:i', $timestamp);

            return $string;
        } else {
            return 'non';
        }
    }

    private function depuisTimestamp($timestamp)
    {
        if ($timestamp != 0) {
            $depuis = $this->timeCourant - $timestamp;
            $string = floor($depuis / 60).' min';

            return $string;
        } else {
            return '';
        }
    }
}
