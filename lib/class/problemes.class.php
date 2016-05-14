<?php
/*
 *
 * Auteur : SoX <flosox@gmail.com>
 * Modification : 08/05/09 par SoX
 *
 * Description : Gestion des problemes
 *
 */

 class problemes
 {
     private $sql;

  // Le constructeur ouvre la connexion sql
  public function __construct()
  {
      $this->sql = new sql();
  }

  // Le destruction ferme la connexion sql
  public function __destruct()
  {
      unset($this->sql);
  }

     public function liste()
     {
         $titles = $this->sql->select('*', 'cat_prob', 'WHERE id != 0');
         $probs = $this->sql->select('liste_prob.id_type_prob, type_prob.id_cat_prob, type_prob.nom, liste_prob.id, liste_prob.gravite', '(liste_prob INNER JOIN type_prob ON liste_prob.id_type_prob = type_prob.id)', 'WHERE type_prob.id_cat_prob != 0 AND id_espace ='.$_SESSION['id_espace']);
         foreach ($titles as $title) {
             ?>
	<h2><?php echo $title['nom'];
             ?></h2>
<?php  $this->liste_problemes($title['id'], $probs);
         }
     }

     private function liste_problemes($id, $probs)
     {
         foreach ($probs as $prob) {
             if ($prob['id_cat_prob'] === $id) {
                 ?>
          <form method="post" action="?action=prob">
<?php	    switch ($prob['gravite']) {
          case 1:?>
	<div class="liste_probleme moyen">
      <input type="hidden" name="id" value="<?php echo $prob['id']; ?>" />
      <input type="hidden" name="id_type" value="<?php echo $prob['id_type_prob']; ?>" />
      <input type="hidden" name="gravite" value="<?php echo $prob['gravite']; ?>" />
	  <input name="nom" value="<?php echo $prob['nom']; ?>" type="submit" />
	  <div class="virgule"><a href="?action=aprob&id=<?php echo $prob['id'].'&id_type='.$prob['id_type_prob'].'&gravite='.$prob['gravite'];?>" title="Valider"></a></div>
	</div>
<?php          break;
          case 2:?>
	<div class="liste_probleme grave">
	  <input value="<?php echo $prob['nom']; ?>" type="button" />
	  <div class="virgule"><a href="?action=aprob&id=<?php echo $prob['id'].'&id_type='.$prob['id_type_prob'].'&gravite='.$prob['gravite'];?>" title="Valilder"></a></div>
	</div>
<?php          break;
          default:?>
	<div class="liste_probleme">
      <input type="hidden" name="id" value="<?php echo $prob['id']; ?>" />
      <input type="hidden" name="id_type" value="<?php echo $prob['id_type_prob']; ?>" />
      <input type="hidden" name="gravite" value="<?php echo $prob['gravite']; ?>" />
	  <input name="nom" value="<?php echo $prob['nom']; ?>" type="submit" />
	</div>
<?php      }
                 ?>
          </form>
<?php
             }
         }
     }

  //ajoute ($sens=1) ou retour ) 0 ($sens = -1) un niveau au prob
  public function prob_niveau($id, $id_type, $gravite, $sens = 1)
  {
      if (isset($_SESSION['id_espace'])) {
          $id_espace = $_SESSION['id_espace'];
      } else {
          $id_espace = 0;
      }

      $plus_gravite = $gravite + 1;

    //on recupère le niveau <== Inutile car tout est passe en POST
    //$gravite = $this->sql->select('gravite', 'liste_prob', "WHERE id_espace='".$id_espace."' AND id='".$id."'");
    if ($sens == 1) {
        if ($gravite == 0) {
            $this->sql->update('liste_prob', "`gravite` = '1'", '`id`='.$id);
        } elseif ($gravite == 1) {
            $this->sql->update('liste_prob', "`gravite` = '2'", '`id`='.$id);
        }
        $this->sql->insert('archive_prob', '`id_liste_prob`, `id_type_prob`, `id_espace`, `heure`, `gravite`', $id.','.$id_type.','.$id_espace.',NOW(),'.$plus_gravite);
    } elseif ($sens == -1) {
        $this->sql->update('liste_prob', "`gravite` = '0', `auteur` = NULL", '`id`='.$id);
        $this->sql->insert('archive_prob', '`id_liste_prob`, `id_type_prob`, `id_espace`, `heure`, `gravite`', $id.','.$id_type.','.$id_espace.',NOW(), 0');
    }
  }
 }
