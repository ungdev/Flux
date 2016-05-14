<?php
//tester si droit
$login  = new login();
if(!$login->verifConnexion() OR (!$login->testDroit('superadmin') AND !$login->testDroit('admin_espaces')))
  header('Location: '.$config['baseDir'].'/manque_droit');

$admin = new admin_administration();

if(isset($_POST['nom']))
{
	//on enregistre
	$admin->enregistrer_espace($_POST['nom'], $_POST['lieu'], $_POST['type_espace'], $_POST['utilisateur'], $_POST['ouvert'], $_POST['id']);
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'supprimer_espace')
{
	$admin->supprimer_espace($_GET['id']);
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'modifier_espace')
{
	$Value = $admin->modifier_espace($_GET['id']);
}
?>
<?php $admin->header() ?>

<form id="form_espace" method="post" action="">
<?php if ($Value['nom']) {
?>  <h1>Modifier :</h1>
  <input type="text" name="nom" value="<?php  echo $Value['nom'];?>" onfocus="if(this.value=='Nom de l\'EàT'){this.value=''};" onBlur="if(this.value==''){this.value='Nom de l\'EàT'};" />
  <input type="text" name="lieu" value="<?php echo $Value['lieu']; ?>" onfocus="if(this.value=='Lieu'){this.value=''};" onBlur="if(this.value==''){this.value='Lieu'};
<?}
else {
?>  <h1>Ajouter :</h1>
  <input type="text" name="nom" value="Nom de l'EàT" onfocus="if(this.value=='Nom de l\'EàT'){this.value=''};" onBlur="if(this.value==''){this.value='Nom de l\'EàT'};" />
  <input type="text" name="lieu" value="Lieu" onfocus="if(this.value=='Lieu'){this.value=''};" onBlur="if(this.value==''){this.value='Lieu'};
<?php }
?>" />
  <select name="type_espace"><?php echo $admin->retourneSelectTypeEspace($Value['id_type_espace']) ?></select>
  <select name="utilisateur"><?php echo $admin->retourneSelectUtilisateur($Value['id_utilisateur']) ?></select>
  <label>Ouvert ? <input type="checkbox" name="ouvert" <?php if($Value['etat']) echo 'checked="checked"' ; ?> /></label>
  <input type="hidden" name="id" value="<?php echo $Value['id'] ?>" />
  <input type="submit" value="Envoyer" />
</form>

<div id="liste_espace">
<?php $admin->liste_espaces(); ?>
</div>

<?php $admin->footer() ?>
