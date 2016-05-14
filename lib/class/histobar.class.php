<?php

/*
    *
    * Auteur : Sid <chateaum@gmail.com>
    * Modification : 14/05/09 par SoX
    *
    * Description : Gestion des historiques
    *
    */

class histobar
{
    private $sql;
    //Resolution du bordel en secondes
    private $resolution;

    private $debut_event;
    private $fin_event;
    private $taillelabel;
    // Le constructeur ouvre la connexion sql
    public function __construct()
    {
        $this->sql = new SQL();

        //Configuration des pseudo constantes de la classes!

        //resolution en secondes du systemme !
        $this->resolution = 60 * 10;
        $this->debut_event = $this->datetores(mktime(20, 0, 0, 5, 16, 2009));
        $this->fin_event = $this->datetores(mktime(4, 0, 0, 5, 17, 2009));
        //Taille d'un message de taille automatique en cases
        $this->taillelabel = 5;
    }

    // Le destruction ferme la connexion sql
    public function __destruct()
    {
        unset($this->sql);
    }

    private function datetores($timestamp)
    {
        return $timestamp - ($timestamp % $this->resolution);
    }

    public function class_que_tu_veux()
    {
        $this->printCSS();
        $espaces = $this->sql->select('*', 'espace', ' ');
        foreach ($espaces as $espace) {
            echo '<h1>'.$espace['nom'].'</h1>';

            $id_espace = $espace['id'];

            //Array of Events que l'on va remplir de la maniere suivante:
            //$aoe[TIMESTAMP][] = EVENEMENT
            //Il peut donc se passer 2 ou plus trucs a la meme minute ;)
            $aoe = array();

            //Problemmes
            $probs = $this->sql->select('tp.nom as nom , UNIX_TIMESTAMP(heure) as date ', 'archive_prob ap,type_prob tp ', " WHERE tp.id = ap.id_type_prob AND id_espace='".$id_espace."'");
            foreach ($probs as $prob) {
                $aoe[$this->datetores($prob['date'])][] = array('type' => 'problemme', 'label' => $prob['nom'], 'duree' => 'auto');
                //Un truc d'enfoirer serias de metre un chap budjet a mois 10 a chaque problemme qui enleve 10Euros au bar par problemme declare (yaka pas leur dire ca fait gagner des sous...)
            }

            //Permanancier
            $datas = $this->sql->select("CONCAT_WS(' ',nom,prenom) as label , UNIX_TIMESTAMP(debut) as start ,UNIX_TIMESTAMP(fin) as end", 'permanancier', "WHERE id_espace='".$id_espace."'");
            foreach ($datas as $data) {
                $aoe[$this->datetores($data['start'])][] = array('type' => 'perm', 'label' => $data['label'], 'duree' => ($this->datetores($data['end']) - $this->datetores($data['start'])));
            }

            //TODO: comprendre le truc et definir ou toruver les valeurs financieres des futs !

            /*
            //Futs
            $datas= $this->sql->select("CONCAT_WS(' ',nom,prenom) as label , UNIX_TIMESTAMP(debut) as start ,UNIX_TIMESTAMP(fin) as end",'permanancier',"WHERE id_espace='".$id_espace."'");
            foreach($datas as $data){
            $aoe[$this->datetores($data['start'])][] = Array('type'=>'perm','label'=>$data['label'],'duree'=>($this->datetores($data['end']) - $this->datetores($data['start'])));
            }

                */

            //Delestage
            $datas = $this->sql->select("CONCAT_WS(' = ',d.somme, u.login ) as label , d.somme as somme, UNIX_TIMESTAMP(d.heure) as start ", 'delestage d , utilisateur u', "WHERE d.id_utilisateur = u.id AND d.id_espace='".$id_espace."'");
            foreach ($datas as $data) {
                $aoe[$this->datetores($data['start'])][] = array('type' => 'delestage', 'label' => $data['label'], 'duree' => 'auto', 'somme' => $data['somme']);
            }

            //Deplacement de fut !
            $datas = $this->sql->select("CONCAT_WS(' = ',s.identifiant, p.quantite_debut ) as label ,  UNIX_TIMESTAMP(p.debut) as start ", 'parcours p , stock s', "WHERE p.id_stock = s.id AND p.id_espace='".$id_espace."'");
            //TODO:un calcul de somme !
            foreach ($datas as $data) {
                //TODO:changer ca  !

                $data['somme'] = 0;

                $aoe[$this->datetores($data['start'])][] = array('type' => 'deplfut', 'label' => $data['label'], 'duree' => 'auto', 'somme' => $data['somme']);
            }

            //Entame de fut !

            echo '<pre>';
//print_r($aoe);
            echo '</pre>';

            $this->printAOE($aoe);
        }
    }

    private function printCSS()
    {
        ?>

			<style>

			table th {
border:solid red 1px;
			}
		table td {
border:solid black 1px;
		}
		</style>

			<?php

    }
    private function printAOE($aoe)
    {
        echo '<table>';
        echo '<tr>';
        for ($i = $this->debut_event;$i < $this->fin_event;$i = $i + $this->resolution) {
            echo '<th>'.date('G:i', $i).'</th>';
        }
        echo '</tr>';
        $vide = false;
        $budjet = array();
        while ($vide != true) {
            $next = 0;
            $vide = true;
            echo '<tr>';
            for ($i = $this->debut_event;$i < $this->fin_event;$i = $i + $this->resolution) {
                if ($i >= $next) {
                    if (isset($aoe[$i]) && count($aoe[$i]) > 0) {
                        $local = array_shift($aoe[$i]);
                        $taille = ($local['duree'] == 'auto') ? $this->taillelabel : $local['duree'] / $this->resolution;
                        $next = $i + $taille * $this->resolution;
                        if (isset($local['budjet'])) {
                            $budjet[$i] += $local['budjet'];
                        }
                        echo '<td colspan="'.$taille.'" class="'.$local['type'].'">'.$local['label'].'</td>';
                    } else {
                        echo '<td>&nbsp;</td>';
                    }
                }
                if (isset($aoe[$i]) && count($aoe[$i]) > 0) {
                    $vide = false;
                }
            }
            echo '</tr>';
        }

        echo '<tr>';
        $somme = 0;
        //La derniere ligne sert a afficher la somme que le bar raporte (peut malheureusement etre tristement negative)
        for ($i = $this->debut_event;$i < $this->fin_event;$i = $i + $this->resolution) {
            if (isset($budjet[$i])) {
                $somme += $budjet[$i];
            }
            //TODO:definir des seuils pour des couleurs si on veut !
            echo '<td>'.$somme.'</td>';
        }
        echo '</tr>';
        echo '</table>';
    }
}
