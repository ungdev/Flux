<?php
	$css = ['iframe'];
	$js = [];
	$title = "Administration";
?>
<form id="form_espace" method="post" action="">
	<?php if (isset($vars['value']['nom'])) { ?>
		<h1>Modifier :</h1>
		<input type="text" name="nom" value="<?php  echo $vars['value']['nom'];?>" onfocus="if(this.value=='Nom de l\'EàT'){this.value=''};" onBlur="if(this.value==''){this.value='Nom de l\'EàT'};" />
		<input type="text" name="lieu" value="<?php echo $vars['value']['lieu']; ?>" onfocus="if(this.value=='Lieu'){this.value=''};" onBlur="if(this.value==''){this.value='Lieu'};" />
	<?php } else { ?>
		<h1>Ajouter :</h1>
		<input type="text" name="nom" value="Nom de l'EàT" onfocus="if(this.value=='Nom de l\'EàT'){this.value=''};" onBlur="if(this.value==''){this.value='Nom de l\'EàT'};" />
		<input type="text" name="lieu" value="Lieu" onfocus="if(this.value=='Lieu'){this.value=''};" onBlur="if(this.value==''){this.value='Lieu'};" />
	<?php } ?>
	<select name="type_espace"><?php echo $vars['admin']->retourneSelectTypeEspace($vars['value']['id_type_espace']??'') ?></select>
	<select name="utilisateur"><?php echo $vars['admin']->retourneSelectUtilisateur($vars['value']['id_utilisateur']??'') ?></select>
	<label>Ouvert ? <input type="checkbox" name="ouvert" <?php if(isset($vars['value']['etat'])) echo 'checked="checked"' ; ?> /></label>
	<input type="hidden" name="id" value="<?php echo $vars['value']['id']??'' ?>" />
	<input type="submit" value="Envoyer" />
</form>

<div id="liste_espace">
<?php $vars['admin']->liste_espaces(); ?>
</div>
