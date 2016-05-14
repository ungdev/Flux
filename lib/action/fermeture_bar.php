<?php
//tester si droit
$login  = new login();
if(!$login->verifConnexion())
  header('Location: '.$config['baseDir'].'/manque_droit');

$admin = new admin_administration();
$sql = new SQL();

//select
if(!isset($_POST['id_espace']) AND !isset($_POST['nb_jetons']))
{
	?>
	<form method="POST" action="">
	<select name="id_espace"><?php echo $admin->retourneSelectEspace($_POST['id_espace']); ?></select>
	<input type="submit" />
	</form>
	<?php
}
//on choppe les jetons
elseif(isset($_POST['id_espace']))
{
	$_SESSION['id_espace'] = $_POST['id_espace'];
	
	?>
	<form method="POST" action="">
	<input type="text" name="nb_jetons" />
	<input type="submit" />
	</form>
	<?php
}
elseif(isset($_POST['nb_jetons']))
{
	$id_espace = $_SESSION['id_espace'];
	$nb_jetons = $_POST['nb_jetons'];
	
	$sql->insert('delestage', '`id_espace`, `somme`, `heure`', "'".$id_espace."', '".$nb_jetons."', NOW( )");
	
	//nb jetons encaissés pdt le gala
	$somme = $sql->select('SUM(somme)', 'delestage', "WHERE id_espace=17 GROUP BY id_espace");
	
	echo '<p>jetons encaissés pendant la soirée : '.$somme[0].'</p>';
	
	//table avec tout les futs
	
	
	

}
