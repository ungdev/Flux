<?php
/*
 *
 * Auteur : SoX <flosox@gmail.com>
 * Modification : 15/05/11 par SoX
 *
 * Description : Gestion des flux
 *
 */

 class flux
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

     public function liste($id_espace)
     {
         $stocks = $this->sql->select('type_stock.nom as nom, type_stock.conditionnement as conditionnement, stock.id, stock.identifiant, UNIX_TIMESTAMP(stock.entame) as entame, UNIX_TIMESTAMP(stock.fin) as fin', '(`type_stock` INNER JOIN stock ON type_stock.id = stock.id_type_stock) INNER JOIN parcours ON stock.id=parcours.id_stock', 'WHERE parcours.id_espace ='.$id_espace.' AND parcours.fin=\'000-00-00 00:00:00\' AND stock.identifiant NOT LIKE "CH%" GROUP BY parcours.id_stock ORDER BY type_stock.nom, identifiant');
         $prec = '';
         echo "<input type='hidden' name='id_espace' value='".$id_espace."' />";
         foreach ($stocks as $stock) {
             if ($prec != $stock['nom']) {
                 ?>
	<div class="title"><span class="h2"><?php echo $stock['nom'];
                 ?></span> - <span><?php echo $stock['conditionnement'];
                 ?></span></div>
<?php  $this->liste_stocks($stock['nom'], $stocks, $id_espace);
             }
             $prec = $stock['nom'];
         }
     }

     private function liste_stocks($nom, $stocks, $id_espace)
     {
         $i = 0;
         foreach ($stocks as $stock) {
             if ($stock['nom'] === $nom) {
                 ++$i;
                 if ($stock['entame'] != 0 && $stock['fin'] == 0) {
                     ?>
	<div class="liste_flux moyen">
	  <button type="submit" name="id_stock" value="<?php echo $stock['id'];
                     ?>" title="<?php echo strtoupper($stock['identifiant']);
                     ?> fini ?"><?php echo strtoupper($stock['identifiant']);
                     ?> ENTAMÉ</button>
<!--	  <input name="<?php echo $stock['id'];
                     ?>" title="<?php echo strtoupper($stock['identifiant']);
                     ?> fini ?" value="<?php echo strtoupper($stock['identifiant']);
                     ?> ENTAMÉ" type="submit" /> -->
      <div class="fleche"><a href="?action=aflux&id=<?php echo $stock['id'].'&id_espace='.$id_espace;
                     ?>" title="Annuler"></a></div>
	</div>
<?php

                 } elseif ($stock['fin'] != 0) {
                     ?>
	<div class="liste_flux grave">
	  <input value="<?php echo strtoupper($stock['identifiant']);
                     ?> FINI" type="button" />
	  <div class="fleche"><a href="?action=aflux&id=<?php echo $stock['id'].'&id_espace='.$id_espace;
                     ?>" title="Annuler"></a></div>
	</div>
<?php

                 } else {
                     ?>
	<div class="liste_flux">
<!--		<input name="<?php echo $stock['id'];
                     ?>" title="<?php echo strtoupper($stock['identifiant']);
                     ?> entamé ?" value="<?php echo strtoupper($stock['identifiant']);
                     ?>" type="submit" /> -->
	  	<button type="submit" name="id_stock" value="<?php echo $stock['id'];
                     ?>" title="<?php echo strtoupper($stock['identifiant']);
                     ?> fini ?"><?php echo strtoupper($stock['identifiant']);
                     ?></button>
	</div>
<?php

                 }
                 if ($i  != 0 && $i % 3 === 0) {
                     ?>
	<br /><br /><br />
<?php

                 }
             }
         }
         if ($i  === 0  || $i % 3 != 0) {
             ?>
	<br /><br /><br />
<?php

         }
     }

  //ajoute ($sens=1) ou retour ) 0 ($sens = -1) un niveau au stock
  public function stock_niveau($id, $id_espace, $sens = 1)
  {
      //on recupère le niveau
    $stock = $this->sql->select('UNIX_TIMESTAMP(`entame`) as entame, UNIX_TIMESTAMP(`fin`) as fin', 'stock', "WHERE id='".$id."'");
      if ($sens == 1) {
          if ($stock['entame'] == 0 and $stock['fin'] == 0) {
              $this->sql->update('stock', '`entame` = NOW( )', '`id`='.$id);
          } elseif ($stock['entame'] != 0 and $stock['fin'] == 0) {
              $this->sql->update('stock', '`fin` = NOW( )', '`id`='.$id);
          }
      } elseif ($sens == -1) {
          if ($stock['entame'] != 0 and $stock['fin'] == 0) {
              $this->sql->update('stock', "`entame` = '0'", '`id`='.$id);
          } elseif ($stock['entame'] != 0 and $stock['fin'] != 0) {
              $this->sql->update('stock', "`fin` = '0'", '`id`='.$id);
          }
      }
        // je recupere id_type_stock de $id
        $result1 = $this->sql->query('SELECT id_type_stock FROM stock WHERE id='.$id);
      $req1 = mysql_fetch_array($result1);
      $id_type_stock = $req1[0];
        // je compte le nombre de fut plein correspondant au $id_type_stock pour $id_espace
        $result3 = $this->sql->query('SELECT COUNT(*) as nb FROM stock LEFT JOIN parcours ON (parcours.id_stock = stock.id) LEFT JOIN espace ON (parcours.id_espace = espace.id) WHERE id_type_stock='.$id_type_stock.' AND id_espace = '.$id_espace.' AND entame = 0 GROUP BY entame');
      $req3 = mysql_fetch_array($result3);
      if (empty($req3)) {
          $req3 = 0;
      }
      $nb_plein = $req3[0];
        //si c'est le dernier fut je retourne une alerte
//  public function prob_niveau($id, $id_type, $gravite, $sens = 1)
        $result = $this->sql->query('SELECT liste_prob.id as id, liste_prob.id_type_prob as type_prob, gravite FROM type_prob LEFT JOIN liste_prob ON (type_prob.id = liste_prob.id_type_prob) WHERE id_cat_prob = 0 AND lien = '.$id_type_stock.' AND id_espace = '.$id_espace);
      $req4 = mysql_fetch_array($result);
      if (!empty($req4)) {
          $prob = new problemes();
          if ($nb_plein == 1) {
              if ($req4['gravite'] == 0) {
                  $prob->prob_niveau($req4['id'], $req4['type_prob'], $req4['gravite'], 1);
              } elseif ($req4['gravite'] == 2) {
                  $prob->prob_niveau($req4['id'], $req4['type_prob'], $req4['gravite'], -1);
              }
          } elseif ($np_total - $nb_plein == 0) {
              if ($req4['gravite'] == 1) {
                  $prob->prob_niveau($req4['id'], $req4['type_prob'], $req4['gravite'], 1);
              }
          } else {
              if ($req4['gravite'] == 1) {
                  $prob->prob_niveau($req4['id'], $req4['type_prob'], $req4['gravite'], -1);
              }
          }
      }
  }
 }
