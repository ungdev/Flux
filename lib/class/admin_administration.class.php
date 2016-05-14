<?php
include 'lib/conf/config_secure.inc';

/*
 *
 * Auteur : Reivax <bernard.xav@gmail.com>
 * Modification : 15/05/11 by SoX <flosox@gmail.com>
 *
 * Description : tout ce dont on a besoin pour la page administration...
 *
 */

class admin_administration
{
    private $sql;

    public function __construct()
    {
        $this->sql = new sql();
    }

  //header des pages iframe... c moche, certe...
  public function header()
  {
      global $config;
      ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <link href='<?php echo $config['tplUrl'];
      ?>/css/iframe.css' rel='stylesheet' type='text/css' />
</head>
<body>
	<?php

  }

  //footer des pages iframe... c moche, certe...
  public function footer()
  {
      ?>
</body>
</html>
	<?php

  }

    public function retourneSelectDroits($valueEx = '')
    {
        $resulat = $this->sql->select('id, nom', 'droit', 'ORDER BY nom');
        $string = '<option value=""></option>';
        foreach ($resulat as $value) {
            if ($value['id'] == $valueEx) {
                $string .= '<option value="'.$value['id'].'" selected="selected">'.$value['nom'].'</option>';
            } else {
                $string .= '<option value="'.$value['id'].'">'.$value['nom'].'</option>';
            }
        }

        return $string;
    }

    public function retourneSelectLogin($valueEx = '')
    {
        $resulat = $this->sql->select('id, login', 'utilisateur', 'ORDER BY login');
        $string = '<option value=""></option>';
        foreach ($resulat as $value) {
            if ($value['id'] == $valueEx) {
                $string .= '<option value="'.$value['id'].'" selected="selected">'.$value['login'].'</option>';
            } else {
                $string .= '<option value="'.$value['id'].'">'.$value['login'].'</option>';
            }
        }

        return $string;
    }

    public function retourneSelectTypeEspace($valueEx = '')
    {
        $resulat = $this->sql->select('id, nom', 'type_espace', 'ORDER BY nom');
        $string = '<option value="">Type</option>';
        foreach ($resulat as $value) {
            if ($value['id'] == $valueEx) {
                $string .= '<option value="'.$value['id'].'" selected="selected">'.$value['nom'].'</option>';
            } else {
                $string .= '<option value="'.$value['id'].'">'.$value['nom'].'</option>';
            }
        }

        return $string;
    }

    public function retourneSelectUtilisateur($valueEx = '')
    {
        $resulat = $this->sql->select('utilisateur.id, login', 'utilisateur', "LEFT JOIN liste_droit ON (utilisateur.id = liste_droit.id_utilisateur) LEFT JOIN droit ON (liste_droit.id_droit = droit.id) WHERE droit.nom = 'bar' ORDER BY login");
        $string = '<option value="">Propriétaire</option>';
        foreach ($resulat as $value) {
            if ($value['id'] == $valueEx) {
                $string .= '<option value="'.$value['id'].'" selected="selected">'.$value['login'].'</option>';
            } else {
                $string .= '<option value="'.$value['id'].'">'.$value['login'].'</option>';
            }
        }

        return $string;
    }

    public function retourneSelectEspace($valueEx = '')
    {
        $resulat = $this->sql->select('id, nom, lieu', 'espace', 'ORDER BY nom');
        $string = '<option value=""></option>';
        foreach ($resulat as $value) {
            if ($value['id'] == $valueEx) {
                $string .= '<option value="'.$value['id'].'" selected="selected">'.$value['nom'].' - '.$value['lieu'].'</option>';
            } else {
                $string .= '<option value="'.$value['id'].'">'.$value['nom'].' - '.$value['lieu'].'</option>';
            }
        }

        return $string;
    }

    public function retourneSelectCatProb($valueEx = '')
    {
        $resulat = $this->sql->select('id, nom', 'cat_prob', 'ORDER BY nom');
        $string = '<option value="">Catégorie</option>';
        foreach ($resulat as $value) {
            if ($value['id'] == $valueEx) {
                $string .= '<option value="'.$value['id'].'" selected="selected">'.$value['nom'].'</option>';
            } else {
                $string .= '<option value="'.$value['id'].'">'.$value['nom'].'</option>';
            }
        }

        return $string;
    }

    public function retourneSelectLien($valueEx = '')
    {
        $resulat = $this->sql->select('id, nom', 'type_stock', 'ORDER BY nom');
        $string = '<option value="">Lié à un stock ?</option><option value="">NON</option>';
        foreach ($resulat as $value) {
            if ($value['id'] == $valueEx) {
                $string .= '<option value="'.$value['id'].'" selected="selected">'.$value['nom'].'</option>';
            } else {
                $string .= '<option value="'.$value['id'].'">'.$value['nom'].'</option>';
            }
        }

        return $string;
    }

    public function enregistrer_utilisateur($login, $password, $exId)
    {
        if (!is_numeric($exId)) {
            $this->sql->insert('utilisateur', '`login`, `pass`', "'".$login."', SHA1('".$password."')");
        } else {
            $this->sql->update('utilisateur', "`login` = '".$login."', `pass` = SHA1('".$password."')", '`id`='.$exId);
        }
    }

    public function enregistrer_droit($login, $droit)
    {
        $this->sql->insert('liste_droit', '`id_utilisateur`, `id_droit`', "'".$login."', '".$droit."'");
    }

    public function enregistrer_espace($nom, $lieu, $type_espace, $utilisateur, $ouvert, $exId)
    {
        if ($ouvert == 'on') {
            $ouvert = 1;
        }

        if (!is_numeric($exId)) {
            $this->sql->insert('espace', '`nom`, `lieu`, `id_type_espace`, `id_utilisateur`, `etat`', "'".$nom."', '".$lieu."', '".$type_espace."', '".$utilisateur."', '".$ouvert."'");
            $id_espace = mysql_insert_id();

        //on chope tout les pb lié à rien du tout, et on les ajoute dans la table liste_prob
        $resultat = $this->sql->select('id', 'type_prob', 'WHERE lien = 0');
            if (is_array($resultat)) {
                foreach ($resultat as $value) {
                    $this->sql->insert('liste_prob', '`id_type_prob`, `id_espace`', "'".$value."', '".$id_espace."'");
                }
            }
        } else {
            $this->sql->update('espace', "`nom` = '".$nom."', `lieu` = '".$lieu."', `id_type_espace` = '".$type_espace."', `id_utilisateur` = '".$utilisateur."', `etat` = '".$ouvert."'", '`id`='.$exId);
        }
    }

    public function enregistrer_type_stock($nom, $reference, $conditionnement, $volume, $valeur_achat, $valeur_vente, $unitaire, $combien, $exId)
    {
        $nom = addslashes($nom);
        if ($unitaire == 'on') {
            $unitaire = 1;
        } else {
            $unitaire = 0;
        }

        if (!is_numeric($exId)) {
            $this->sql->insert('type_stock', '`nom`, `reference`, `conditionnement`, `volume`, `valeur_achat`, `valeur_vente`, `unitaire`', "'".$nom."', '".$reference."', '".$conditionnement."', '".$volume."', '".$valeur_achat."', '".$valeur_vente."', '".$unitaire."'");
            $id_type_stock = mysql_insert_id();
        } else {
            $this->sql->update('type_stock', "`nom` = '".$nom."', `reference` = '".$reference."', `conditionnement` = '".$conditionnement."', `volume` = '".$volume."', `valeur_achat` = '".$valeur_achat."', `valeur_vente` = '".$valeur_vente."', `unitaire` = '".$unitaire."'", '`id`='.$exId);
            $id_type_stock = $exId;
        }
    //combien ?
    //on compte le nombre d'entités de ce type dans le stock
    $combienEx = $this->sql->select_count('id', 'stock', "WHERE id_type_stock='".$id_type_stock."'");
        if ($combien != $combienEx) {
            if ($combienEx == 0) {
                for ($i = 1;$i <= $combien;++$i) {
                    if ($i < 10) {
                        $index = '0'.$i;
                    } else {
                        $index = $i;
                    }
                    $this->sql->insert('stock', '`id_type_stock`, `identifiant`', "'".$id_type_stock."', '".strtoupper($reference).$index."'");
                }
            } elseif ($combien < $combienEx) {
                $this->sql->delete('stock', 'id_type_stock = '.$id_type_stock);

                for ($i = 1;$i <= $combien;++$i) {
                    if ($i < 10) {
                        $index = '0'.$i;
                    } else {
                        $index = $i;
                    }
                    $this->sql->insert('stock', '`id_type_stock`, `identifiant`', "'".$id_type_stock."', '".strtoupper($reference).$index."'");
                }
            } elseif ($combien > $combienEx) {
                for ($i = $combienEx + 1;$i <= $combien;++$i) {
                    if ($i < 10) {
                        $index = '0'.$i;
                    } else {
                        $index = $i;
                    }
                    $this->sql->insert('stock', '`id_type_stock`, `identifiant`', "'".$id_type_stock."', '".strtoupper($reference).$index."'");
                }
            }
        }
    }

    public function enregistrer_type_prob($nom, $id_cat_prob, $lien, $exId)
    {
        if (!is_numeric($exId)) {
            $this->sql->insert('type_prob', '`nom`, `id_cat_prob`, `lien`', "'".$nom."', '".$id_cat_prob."', '".$lien."'");
            $id_type_prob = mysql_insert_id();
        } else {
            $this->sql->update('type_prob', "`nom` = '".$nom."', `id_cat_prob` = '".$id_cat_prob."', `lien` = '".$lien."'", '`id`='.$exId);
            $id_type_prob = $exId;
        }

    //si lié à rien, on l'ajoute à tous le monde dans liste_prob.. avant, dans le doute, on supprime tous avant, et on rajoute
    //on l'ajoute pour chaque espace si il n'a pas de lien
    $this->sql->delete('liste_prob', 'id_type_prob = '.$id_type_prob);
        if ($lien == '') {
            $resulat = $this->sql->select('id', 'espace', '');
            foreach ($resulat as $value) {
                $this->sql->insert('liste_prob', '`id_type_prob`, `id_espace`', "'".$id_type_prob."', '".$value."'");
            }
        }
    //sinon, que à ceux qui ont du stock
    else {
        $resultat = $this->sql->select('id_espace', 'parcours', "INNER JOIN stock ON (stock.id = parcours.id_stock) WHERE stock.id_type_stock='".$lien."' GROUP BY parcours.id_espace");
        if (is_array($resultat)) {
            foreach ($resultat as $value) {
                $this->sql->insert('liste_prob', '`id_type_prob`, `id_espace`', "'".$id_type_prob."', '".$value."'");
            }
        }
    }
    }

    public function liste_utilisateurs()
    {
        $resultat = $this->sql->select('id, login', 'utilisateur', 'ORDER BY login');

        echo '<table>';
        foreach ($resultat as $value) {
            echo '<tr>';
            echo '<td>'.$value['login'].'</td>';
            echo '<td><a class="modif" title="Modifier '.$value['login'].'" href="?action=modifier_utilisateur&id='.$value['id'].'"></a></td>';
            echo '<td><a class="suppr" title="Supprimer '.$value['login'].'" href="?action=supprimer_utilisateur&id='.$value['id'].'"></a></td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    public function liste_droits()
    {
        $resultat = $this->sql->select('liste_droit.id, utilisateur.login, droit.nom', 'utilisateur', 'INNER JOIN liste_droit ON (utilisateur.id = liste_droit.id_utilisateur) LEFT JOIN droit ON (liste_droit.id_droit = droit.id) ORDER BY utilisateur.login');

        echo '<table>';
        foreach ($resultat as $value) {
            echo '<tr>';
            echo '<td>'.$value['login'].'</td>';
            echo '<td>'.$value['nom'].'</td>';
            echo '<td><a class="suppr_utilisateur" title="Supprimer ce droit de '.$value['login'].'" href="?action=supprimer_droit&id='.$value['id'].'"></a></td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    public function liste_espaces()
    {
        $resultat = $this->sql->select('espace.id, espace.nom AS nom_bar, lieu, login, type_espace.nom AS type_nom, etat', 'espace', 'LEFT JOIN utilisateur ON (espace.id_utilisateur = utilisateur.id) LEFT JOIN type_espace ON (espace.id_type_espace = type_espace.id)');

        echo '<div>';
        if (isset($resultat['nom_bar'])) {
            echo '<h2>'.$resultat['nom_bar'].'</h2>';
            echo '<h3>'.$resultat['lieu'].' - '.$resultat['login'].'</h3>';
            echo '<p> '.$resultat['type_nom'].' - ';
            if ($resultat['etat']) {
                echo 'ouvert<br />';
            } else {
                echo 'fermé<br />';
            }
            echo '<a href="?action=modifier_espace&id='.$resultat['id'].'">modifier</a> | <a href="?action=supprimer_espace&id='.$resultat['id'].'">supprimer</a></p>';
        } else {
            foreach ($resultat as $value) {
                echo '<h2>'.$value['nom_bar'].'</h2>';
                echo '<h3>'.$value['lieu'].' - '.$value['login'].'</h3>';
                echo '<p> '.$value['type_nom'].' - ';
                if ($value['etat']) {
                    echo 'ouvert<br />';
                } else {
                    echo 'fermé<br />';
                }
                echo '<a href="?action=modifier_espace&id='.$value['id'].'">modifier</a> | <a href="?action=supprimer_espace&id='.$value['id'].'">supprimer</a></p>';
            }
        }
        echo '</div>';
    }

    public function liste_stock()
    {
        $resultat = $this->sql->select('id, nom, reference, conditionnement, volume, valeur_achat, valeur_vente, unitaire', 'type_stock', 'ORDER BY nom');
    //on chope le nombre de chaque
    $combien = $this->sql->select('id_type_stock, COUNT(id) as somme', 'stock', 'GROUP BY id_type_stock');
        $retour = array();
        foreach ($combien as $value) {
            $retour[$value['id_type_stock']] = $value['somme'];
        }

        echo '<div>';
        if (isset($resultat['nom_bar'])) {
            echo '<h2>'.$resultat['nom'].'</h2>';
            echo '<p>'.$resultat['conditionnement'].' (<strong>'.$retour[$resultat['id']].'</strong>)<br />';
            echo $resultat['reference'].' - '.$resultat['volume'];
            if ($resultat['unitaire']) {
                echo ' - unitaire';
            }
            echo '<br />Prix : '.$resultat['valeur_achat'].' / '.$resultat['valeur_vente'].'<br />';
            echo '<a href="?action=modifier_espace&id='.$resultat['id'].'">modifier</a> | <a href="?action=supprimer_espace&id='.$resultat['id'].'">supprimer</a></p>';
        } else {
            foreach ($resultat as $value) {
                echo '<h2>'.$value['nom'].'</h2>';
                echo '<p>'.$value['conditionnement'].' (<strong>'.$retour[$value['id']].'</strong>)<br />';
                echo $value['reference'].' - '.$value['volume'];
                if ($value['unitaire']) {
                    echo ' - unitaire';
                }
                echo '<br />Prix : '.$value['valeur_achat'].' / '.$value['valeur_vente'].'<br />';
                echo '<a href="?action=modifier_type_stock&id='.$value['id'].'">modifier</a> | <a href="?action=supprimer_type_stock&id='.$value['id'].'">supprimer</a></p>';
            }
        }
        echo '</div>';
    }

    public function liste_problemes()
    {
        $titles = $this->sql->select('*', 'cat_prob');
        $resultat = $this->sql->select('type_prob.id, type_prob.nom as nom_prob, type_prob.id_cat_prob as id_cat_prob, cat_prob.nom as nom_cat_prob, type_stock.nom as nom_type_stock', 'type_prob', 'LEFT JOIN cat_prob ON (type_prob.id_cat_prob = cat_prob.id) LEFT JOIN type_stock ON (type_prob.lien = type_stock.id)');
        foreach ($titles as $title) {
            ?>
	<h2><?php echo $title['nom'];
            ?></h2>
<?php  $this->liste_problemes_details($title['id'], $resultat);
        }
    }

    private function liste_problemes_details($id, $probs)
    {
        echo '<table>';
        foreach ($probs as $prob) {
            if ($prob['id_cat_prob'] === $id) {
                echo '<tr>';
                echo '<td><h3>'.$prob['nom_prob'].'</h3>';
                if ($prob['nom_type_stock']) {
                    echo '<p>Lié aux stocks "'.$prob['nom_type_stock'].'"</p></td>';
                }
                echo '<td><a class="modif" title="Modifier '.$prob['nom_prob'].'" href="?action=modifier_type_prob&id='.$prob['id'].'"></a></td>';
                echo '<td><a class="suppr" title="Supprimer '.$prob['nom_prob'].'" href="?action=supprimer_type_prob&id='.$prob['id'].'"></a></td>';
                echo '</tr>';
            }
        }
        echo '</table>';
    }

    public function modifier_espace($id)
    {
        $result = $this->sql->select('id, nom, lieu, id_type_espace, id_utilisateur, etat', 'espace', "WHERE id='".$id."'");

        return $result;
    }

    public function modifier_utilisateur($id)
    {
        $result = $this->sql->select('id, login', 'utilisateur', "WHERE id='".$id."'");

        return $result;
    }

    public function modifier_type_stock($id)
    {
        $result = $this->sql->select('*', 'type_stock', "WHERE id='".$id."'");
        $combienEx = $this->sql->select_count('id', 'stock', "WHERE id_type_stock='".$id."'");
        $result['combien'] = $combienEx;

        return $result;
    }

    public function modifier_type_prob($id)
    {
        $result = $this->sql->select('*', 'type_prob', "WHERE id='".$id."'");

        return $result;
    }

    public function supprimer_utilisateur($id)
    {
        $this->sql->delete('utilisateur', 'id = '.$id);
    }

    public function supprimer_droit($id)
    {
        $this->sql->delete('liste_droit', 'id = '.$id);
    }

    public function supprimer_espace($id)
    {
        $this->sql->delete('espace', 'id = '.$id);

    //on supprime aussi tous ses pb dans liste_prob
    $this->sql->delete('liste_prob', 'id_espace = '.$id);
    }

    public function supprimer_type_stock($id)
    {
        $this->sql->delete('type_stock', 'id = '.$id);

    //on supprime aussi tous les pb de la table liste_prob
    ////////////////////////////////////////////////////////////////
    }

    public function supprimer_type_prob($id)
    {
        $this->sql->delete('type_prob', 'id = '.$id);
        $this->sql->delete('liste_prob', 'id_type_prob = '.$id);
    }
}
