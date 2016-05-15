<?php
	$css = ['iframe'];
	$js = [];
	$title = "Administration";
?>
<form id="form_stock" method="post" action="">

	<?php if (isset($vars['value']) && isset($vars['value']['nom'])) { ?>
	<h1>Modifier :</h1>
		<input type="text" name="nom" value="<?php  echo $vars['value']['nom'];?>" onFocus="if(this.value=='Nom (ex: Champagne)'){this.value=''};" onBlur="if(this.value==''){this.value='Nom (ex: Champagne)'};" />
		<input type="text" name="reference" value="<?php  echo $vars['value']['reference'];?>" onFocus="if(this.value=='Référence (ex: CH)'){this.value=''};" onBlur="if(this.value==''){this.value='Référence (ex: CH)'};" />
		<input type="text" name="conditionnement" value="<?php  echo $vars['value']['conditionnement'];?>" onFocus="if(this.value=='Conditionnement'){this.value=''};" onBlur="if(this.value==''){this.value='Conditionnement'};" />
		<input type="text" name="volume" value="<?php  echo $vars['value']['volume'];?>" onFocus="if(this.value=='Vol. / Nbre (ex: 6)'){this.value=''};" onBlur="if(this.value==''){this.value='Vol. / Nbre (ex: 6)'};" />
		<input type="text" name="valeur_achat" value="<?php  echo $vars['value']['valeur_achat'];?>" onFocus="if(this.value=='Val. achat (ex: 87.12)'){this.value=''};" onBlur="if(this.value==''){this.value='Val. achat (ex: 87.12)'};" />
		<input type="text" name="valeur_vente" value="<?php echo $vars['value']['valeur_vente'];;?>" onFocus="if(this.value=='Val. vente (ex: 100.00)'){this.value=''};" onBlur="if(this.value==''){this.value='Val. vente (ex: 100.00)'};" />
		<input type="text" name="combien" value="<?php echo $vars['value']['combien']; ?>" onFocus="if(this.value=='Combien (ex: 40)'){this.value=''};" onBlur="if(this.value==''){this.value='Combien (ex: 40)'};" />
		<input type="hidden" name="id" value="<?php echo $vars['value']['id'] ?>" />
	<?php } else { ?>
	<h1>Ajouter :</h1>
		<input type="text" name="nom" value="Nom (ex: Champagne)" onFocus="if(this.value=='Nom (ex: Champagne)'){this.value=''};" onBlur="if(this.value==''){this.value='Nom (ex: Champagne)'};" />
		<input type="text" name="reference" value="Référence (ex: CH)" onFocus="if(this.value=='Référence (ex: CH)'){this.value=''};" onBlur="if(this.value==''){this.value='Référence (ex: CH)'};" />
		<input type="text" name="conditionnement" value="Conditionnement" onFocus="if(this.value=='Conditionnement'){this.value=''};" onBlur="if(this.value==''){this.value='Conditionnement'};" />
		<input type="text" name="volume" value="Vol. / Nbre (ex: 6)" onFocus="if(this.value=='Vol. / Nbre (ex: 6)'){this.value=''};" onBlur="if(this.value==''){this.value='Vol. / Nbre (ex: 6)'};" />
		<input type="text" name="valeur_achat" value="Val. achat (ex: 87.12)" onFocus="if(this.value=='Val. achat (ex: 87.12)'){this.value=''};" onBlur="if(this.value==''){this.value='Val. achat (ex: 87.12)'};" />
		<input type="text" name="valeur_vente" value="Val. vente (ex: 100.00)" onFocus="if(this.value=='Val. vente (ex: 100.00)'){this.value=''};" onBlur="if(this.value==''){this.value='Val. vente (ex: 100.00)'};" />
		<input type="text" name="combien" value="Combien (ex: 40)" onFocus="if(this.value=='Combien (ex: 40)'){this.value=''};" onBlur="if(this.value==''){this.value='Combien (ex: 40)'};" />
	<?php } ?>

	<label>Unitaire ? <input type="checkbox" name="unitaire" <?php if(!empty($vars['value']) && isset($vars['value']['unitaire'])) echo 'checked="checked"' ; ?> /></label>
	<p>(cochée pour champagne, pack de softs... mais pas pour fût ou trucs au litre)</p>
	<input type="submit" value="Envoyer" />
</form>

<div id="liste_stock">
	<?php $vars['admin']->liste_stock(); ?>
</div>
