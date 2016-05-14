<?php
//tester si droit
$login  = new Login();
if(!$login->isConnected() OR !$login->testDroit('superadmin'))
  header('Location: '.$config['baseDir'].'/manque_droit');

$admin = new admin_administration();

if(isset($_POST['login']))
{
	//on enregistre
	$admin->enregistrer_utilisateur($_POST['login'], $_POST['password'], $_POST['id_utilisateur']);
}
elseif(isset($_POST['loginDroit']))
{
	//on enregistre
	$admin->enregistrer_droit($_POST['loginDroit'], $_POST['droit']);
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'supprimer_utilisateur')
{
	$admin->supprimer_utilisateur($_GET['id']);
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'modifier_utilisateur')
{
	$ValueEx = $admin->modifier_utilisateur($_GET['id']);
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'supprimer_droit')
{
	$ValueEx = $admin->supprimer_droit($_GET['id']);
}
?>
<?php $admin->header() 

?>

<form method="post" action="">
<?php if ($ValueEx['login']) {
?>  <h1>Modifier :</h1>
  <input type="text" name="login" value="<?php  echo $ValueEx['login'];
}
else {
?>  <h1>Ajouter :</h1>
  <input type="text" name="login" value="Login<?php }
?>" onfocus="if(this.value=='Login'){this.value=''};" onBlur="if(this.value==''){this.value='Login'};" />
  <input type="text" name="password" value="Mot de passe" onfocus="if(this.value=='Mot de passe'){this.value=''};" onBlur="if(this.value==''){this.value='Mot de passe'};" />
  <input type="hidden" name="id_utilisateur" value="<?php echo $ValueEx['id'] ?>" />
  <input id="submit_utilisateur" type="submit" value="Envoyer" />
</form>

<div id="liste_utilisateur">
<?php $admin->liste_utilisateurs(); ?>
</div>

<form id="form_droit" method="post" action="">
<h1>Ajouter des droits</h1>
<label>Login :
<select name="loginDroit"><?php echo $admin->retourneSelectLogin() ?></select>
</label>
<label>Droits :
<select name="droit"><?php echo $admin->retourneSelectDroits() ?></select>
</label>
<input id="submit_utilisateur" type="submit" value="Ajouter" />
</form>

<div id="liste_utilisateur">
<?php $admin->liste_droits(); ?>
</div>

<?php $admin->footer() ?>
