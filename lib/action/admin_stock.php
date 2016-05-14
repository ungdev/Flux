<?php
//tester si droit
$login  = new Login();
if(!$login->isConnected() OR (!$login->testDroit('superadmin') AND !$login->testDroit('admin_stock')))
  header('Location: '.$config['baseDir'].'/manque_droit');

$admin = new admin_administration();


if(isset($_POST['nom']))
{
	//on enregistre
	$admin->enregistrer_type_stock($_POST['nom'], $_POST['reference'], $_POST['conditionnement'], $_POST['volume'], $_POST['valeur_achat'], $_POST['valeur_vente'], $_POST['unitaire'], $_POST['combien'], $_POST['id']);
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'supprimer_type_stock')
{
	$admin->supprimer_type_stock($_GET['id']);
}
elseif(isset($_GET['action']) AND $_GET['action'] == 'modifier_type_stock')
{
	$Value = $admin->modifier_type_stock($_GET['id']);
}
?>
<?php $admin->header() ?>

<form id="form_stock" method="post" action="">
<?php if ($Value['nom']) {
?>  <h1>Modifier :</h1>
  <input type="text" name="nom" value="<?php  echo $Value['nom'];?>" onFocus="if(this.value=='Nom (ex: Champagne)'){this.value=''};" onBlur="if(this.value==''){this.value='Nom (ex: Champagne)'};" />
  <input type="text" name="reference" value="<?php  echo $Value['reference'];?>" onFocus="if(this.value=='Référence (ex: CH)'){this.value=''};" onBlur="if(this.value==''){this.value='Référence (ex: CH)'};" />
  <input type="text" name="conditionnement" value="<?php  echo $Value['conditionnement'];?>" onFocus="if(this.value=='Conditionnement'){this.value=''};" onBlur="if(this.value==''){this.value='Conditionnement'};" />
  <input type="text" name="volume" value="<?php  echo $Value['volume'];?>" onFocus="if(this.value=='Vol. / Nbre (ex: 6)'){this.value=''};" onBlur="if(this.value==''){this.value='Vol. / Nbre (ex: 6)'};" />
  <input type="text" name="valeur_achat" value="<?php  echo $Value['valeur_achat'];?>" onFocus="if(this.value=='Val. achat (ex: 87.12)'){this.value=''};" onBlur="if(this.value==''){this.value='Val. achat (ex: 87.12)'};" />
  <input type="text" name="valeur_vente" value="<?php echo $Value['valeur_vente'];;?>" onFocus="if(this.value=='Val. vente (ex: 100.00)'){this.value=''};" onBlur="if(this.value==''){this.value='Val. vente (ex: 100.00)'};" />
  <input type="text" name="combien" value="<?php echo $Value['combien']; ?>" onFocus="if(this.value=='Combien (ex: 40)'){this.value=''};" onBlur="if(this.value==''){this.value='Combien (ex: 40)'};
<?}
else {
?>  <h1>Ajouter :</h1>
  <input type="text" name="nom" value="Nom (ex: Champagne)" onFocus="if(this.value=='Nom (ex: Champagne)'){this.value=''};" onBlur="if(this.value==''){this.value='Nom (ex: Champagne)'};" />
  <input type="text" name="reference" value="Référence (ex: CH)" onFocus="if(this.value=='Référence (ex: CH)'){this.value=''};" onBlur="if(this.value==''){this.value='Référence (ex: CH)'};" />
  <input type="text" name="conditionnement" value="Conditionnement" onFocus="if(this.value=='Conditionnement'){this.value=''};" onBlur="if(this.value==''){this.value='Conditionnement'};" />
  <input type="text" name="volume" value="Vol. / Nbre (ex: 6)" onFocus="if(this.value=='Vol. / Nbre (ex: 6)'){this.value=''};" onBlur="if(this.value==''){this.value='Vol. / Nbre (ex: 6)'};" />
  <input type="text" name="valeur_achat" value="Val. achat (ex: 87.12)" onFocus="if(this.value=='Val. achat (ex: 87.12)'){this.value=''};" onBlur="if(this.value==''){this.value='Val. achat (ex: 87.12)'};" />
  <input type="text" name="valeur_vente" value="Val. vente (ex: 100.00)" onFocus="if(this.value=='Val. vente (ex: 100.00)'){this.value=''};" onBlur="if(this.value==''){this.value='Val. vente (ex: 100.00)'};" />
  <input type="text" name="combien" value="Combien (ex: 40)" onFocus="if(this.value=='Combien (ex: 40)'){this.value=''};" onBlur="if(this.value==''){this.value='Combien (ex: 40)'};
<?php }
?>" />

<label>Unitaire ? <input type="checkbox" name="unitaire" <?php if($Value['unitaire']) echo 'checked="checked"' ; ?> /></label>
<p>(cochée pour champagne, pack de softs... mais pas pour fût ou trucs au litre)</p>
<input type="hidden" name="id" value="<?php echo $Value['id'] ?>" />
<input type="submit" value="Envoyer" />
</form>

<div id="liste_stock">
<?php $admin->liste_stock(); ?>
</div>

<?php $admin->footer() ?>
