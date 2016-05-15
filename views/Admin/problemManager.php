<?php
	$css = ['iframe'];
	$js = [];
	$title = "Administration";
?>
<form id="form_type_prob" method="post" action="">
<?php
if (!empty($vars['value'])) {
	echo '<h1>Modifier :</h1>';
}
else {
	echo '<h1>Ajouter :</h1>';
}
?>

<input type="text" name="nom" value="<?= $vars['value']['nom']??'Nom' ?>" onfocus="if(this.value=='Nom'){this.value=''};" onBlur="if(this.value==''){this.value='Nom'};" />
  <select name="id_cat_prob"><?php echo $vars['admin']->retourneSelectCatProb($vars['value']['id_cat_prob']??'') ?></select>
  <select name="lien"><?php echo $vars['admin']->retourneSelectLien($vars['value']['lien']??'') ?></select>
  <input type="hidden" name="id" value="<?php echo $vars['value']['id']??'' ?>" />
  <input type="submit" value="Envoyer" />
</form>

<div id="liste_problemes">
	<?php $vars['admin']->liste_problemes(); ?>
</div>
