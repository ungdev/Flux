<?php
/*
 *
 * Auteur : SoX <flosox@gmail.com>
 * Modification : 11/05/09 par SoX
 *
 * Description : Tout ce dont on a besoin pour l'onglet problemes
 *
 */

class admin_problemes
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

  public function liste(){
	echo '<div id="h_pb_load"></div>';
    	global $login;
	if ($login->testDroit('secutt')){
		$probs = $this->sql->select("espace.id as id_espace, espace.nom as nom_espace, espace.lieu, type_prob.nom,type_prob.id as prob_type_id, liste_prob.gravite, liste_prob.auteur, liste_prob.id as prob_id", '`liste_prob` INNER JOIN type_prob ON liste_prob.id_type_prob = type_prob.id INNER JOIN espace ON liste_prob.id_espace = espace.id', 'WHERE gravite >= 1 AND type_prob.id=15');
	}else{
		$probs = $this->sql->select("espace.id as id_espace, espace.nom as nom_espace, espace.lieu, type_prob.nom,type_prob.id as probi_type_id, liste_prob.gravite, liste_prob.auteur, liste_prob.id as prob_id", '`liste_prob` INNER JOIN type_prob ON liste_prob.id_type_prob = type_prob.id INNER JOIN espace ON liste_prob.id_espace = espace.id', 'WHERE gravite >= 1');
	}


	if(isset($probs['nom_espace'])){ ?>
		<h2><?php echo $probs['nom_espace'].' ('.$probs['lieu'].')'; ?></h2>
		<table id="table_admin_problemes">
<?php 			$this->valeur_problemes($probs['id_espace'], $probs); ?>
		</table>
<?php
	}elseif (is_array($probs)){
		$prec="";
		foreach ($probs as $prob){
?><table><?php
  			if($prec != $prob['nom_espace']){ ?>
				<h2><?php echo $prob['nom_espace'].' ('.$prob['lieu'].')'; ?></h2>
				<table id="table_admin_problemes">
<?php 					$this->liste_problemes($prob['id_espace'], $probs);
					$prec = $prob['nom_espace'];
			}
?></table><?php
      		}
	}else{ ?>
		<h2>Il n'y a actuellement aucun problème signalé.</h2>
<?php	}?>
	</table>
<?php  }

  private function liste_problemes($id, $probs)
  {
    foreach ($probs as $prob)
	{
      $this->valeur_problemes ($id, $prob);
    }
  }

  private function valeur_problemes ($id, $prob){
	if ($prob['id_espace'] === $id){ ?>
		<tr>
			<td><form method="post" action="/admin?action=prob">
<?php	  	switch ($prob['gravite']){
			case 1: ?>
				<div class="liste_probleme moyen admin">
	  				<input name="nom" value="<?php echo $prob['nom']; ?>" type="button" onclick="document.location.href = '/admin?action=aprob&id=<?php echo $prob['prob_id'].'&id_type='.$prob['probi_type_id'].'&gravite='.$prob['gravite'] ;?>';" />
				</div>
<?php   			break;
			case 2: ?>
				<div class="liste_probleme grave admin">
					<input name="nom" value="<?php echo $prob['nom']; ?>" type="button" onclick="document.location.href = '/admin?action=aprob&id=<?php echo $prob['prob_id'].'&id_type='.$prob['probi_type_id'].'&gravite='.$prob['gravite'] ;?>';" />
				</div>
<?php          			break;

          		default: ?>
				<div class="liste_probleme admin">
					<input name="nom" value="<?php echo $prob['nom']; ?>" type="button" onclick="document.location.href = '/admin?action=aprob&id=<?php echo $prob['prob_id'].'&id_type='.$prob['probi_type_id'].'&gravite='.$prob['gravite'] ;?>';" />
				</div>
<?php      }?>
  			</form></td>
<?php     		 $this->charge_problemes($prob['prob_id'], $prob['auteur']); ?>
			</tr>
<?php   }
  }

  private function charge_problemes ($id, $auteur) {?>
	<td>
		<form id="form_problemes_admin_<?php echo $id ?>" class="form_problemes_admin" method="post" action="admin_problemes">
		<label>Pris en charge par :</label>
<?php if ($auteur) {
?>  			<input class="input_form_problemes" type="text" name="auteur" value="<?php  echo $auteur;
}else {
?> 		 	<input class="input_form_problemes" type="text" name="auteur" value="Personne
<?php }
?>" onfocus="if(this.value=='Personne'){this.value=''};" onBlur="if(this.value==''){this.value='Personne'};" />
			<input type="hidden" name="id" value="<?php echo $id ?>" />
			<input class="submit_form_problemes" type="submit" value="Enregistrer" />
		</form>
	</td>

<?php  }

	public function enregistrerAuteur($id_pb, $nom_auteur)
	{
		$this->sql->update('liste_prob', "`auteur` = '".$nom_auteur."'", '`id`='.$id_pb);
		//$this->sql->insert('utilisateur', '`login`', "'".$nom_auteur.$id_pb."'");
	}

}
