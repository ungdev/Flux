<?php
//tester si droit
$login  = new Login();
if(!$login->isConnected() OR !$login->testDroit('superadmin'))
  header('Location: '.$config['baseDir'].'/manque_droit');

$admin = new admin_administration();

if(isset($_POST['nom']))
{
	//on enregistre
	$admin->enregistrer_type_prob($_POST['nom'], $_POST['id_cat_prob'], $_POST['lien'], $_POST['id']);
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'supprimer_type_prob')
{
	$admin->supprimer_type_prob($_GET['id']);
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'modifier_type_prob')
{
	$Value = $admin->modifier_type_prob($_GET['id']);
}
?>
<?php $admin->header() ?>

<form id="form_type_prob" method="post" action="">
<?php if ($Value['nom']) {
?>  <h1>Modifier :</h1>
  <input type="text" name="nom" value="<?php  echo $Value['nom'];
}
else {
?>  <h1>Ajouter :</h1>
  <input type="text" name="nom" value="Nom<?php }
?>" onfocus="if(this.value=='Nom'){this.value=''};" onBlur="if(this.value==''){this.value='Nom'};" />
  <select name="id_cat_prob"><?php echo $admin->retourneSelectCatProb($Value['id_cat_prob']) ?></select>
  <select name="lien"><?php echo $admin->retourneSelectLien($Value['lien']) ?></select>
  <input type="hidden" name="id" value="<?php echo $Value['id'] ?>" />
  <input type="submit" value="Envoyer" />
</form>

<div id="liste_problemes">
<?php $admin->liste_problemes(); ?>
</div>

<?php $admin->footer() ?>
