<?php
	$css = ['iframe'];
	$js = [];
	$title = "Administration";
?>
<form method="post" action="">
	<?php if (isset($vars['value']['login'])) { ?>
		<h1>Modifier :</h1>
	<?php } else { ?>
		<h1>Ajouter :</h1>
	<?php } ?>

	<input type="text" name="login" value="<?= $vars['value']['login']??'Login'; ?>" onfocus="if(this.value=='Login'){this.value=''};" onBlur="if(this.value==''){this.value='Login'};" />
	<input type="text" name="password" value="Mot de passe" onfocus="if(this.value=='Mot de passe'){this.value=''};" onBlur="if(this.value==''){this.value='Mot de passe'};" />
	<input type="hidden" name="id_utilisateur" value="<?php echo $vars['value']['id']??'' ?>" />
	<input id="submit_utilisateur" type="submit" value="Envoyer" />
</form>

<div id="liste_utilisateur">
	<?php $vars['admin']->liste_utilisateurs(); ?>
</div>

<form id="form_droit" method="post" action="">
	<h1>Ajouter des droits</h1>
	<label>Login :
		<select name="loginDroit"><?php echo $vars['admin']->retourneSelectLogin() ?></select>
	</label>
	<label>Droits :
		<select name="droit"><?php echo $vars['admin']->retourneSelectDroits() ?></select>
	</label>
	<input id="submit_utilisateur" type="submit" value="Ajouter" />
</form>

<div id="liste_utilisateur">
	<?php $vars['admin']->liste_droits(); ?>
</div>
