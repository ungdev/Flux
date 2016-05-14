<?php
die("page desactivée");
echo '<pre>';
print_r($_POST);
echo '</pre>';

echo ($_POST['bouton1'].'<br />');

echo key($_POST);

?>


<form method="POST" action="">
	<input type="hidden" name="a" value="hidden_a" />
    <input type="hidden" name="b" value="hidden_b" />
	<input type="submit" name="bouton1" value="b1" />
	<input type="submit" name="bouton2" value="b2" />
	<input type="submit" name="bouton3" value="b3" />
	<input type="submit" name="bouton4" value="b4" />
</form>


<?php
/*

$sql = new sql();
$combien = $sql->select('id, COUNT(id) as somme', 'stock', "GROUP BY id_type_stock");

$retour = array();
foreach($combien as $value)
{
	$retour[$value['id']] = $value['somme'];
}

echo '<pre>';
print_r($retour);
echo '</pre>';

//$sql->update('type_espace', "`nom` = 'Espace à thème'", '`id`=1');

/*$resulat = $sql->select('id, nom', 'droit', "");
$string;
foreach($resulat as $value)
{
  $string .= '<option value="'.$value['id'].'">'.$value['nom'].'</option>';
}
=======
    $query1 = $sql->query("SELECT id, nom FROM droit ORDER BY nom");
	$droits=array();
	while ($table = mysql_fetch_assoc($query1))
	{
		$droits[]=$table;
	}
	
	$query2 = $sql->query("SELECT utilisateur.id, login, UNIX_TIMESTAMP(`derniere_connexion`) as derniere_connexion FROM espace INNER JOIN utilisateur ON (espace.id_utilisateur = utilisateur.id) WHERE `etat`=1 ORDER BY `login`");
	$admins=array();
	while ($table = mysql_fetch_assoc($query2))
	{
		$admins[]=$table;
	}
>>>>>>> .r967

	
	echo '<h2>Parler à une liste :</h2>';
	
	foreach($droits as $value)
	{
	  echo '<div><a id="'.$value['nom'].'" class="choix_chat" href="chat&action=toliste&id='.$value['id'].'">'.$value['nom'].'</a></div>';
	}
	
	echo '<h2>Parler seulement à un EAT :</h2>';
	
	foreach($admins as $value)
	{
	  if($value['derniere_connexion'] > (time()-120))
	  	echo '<div class="online"><a id="'.$value['login'].'" class="choix_chat" href="chat&action=toqqn&id='.$value['id'].'">'.$value['login'].'</a>';  
	  else
	  	echo '<div class="offline"><a id="'.$value['login'].'" class="choix_chat" href="chat&action=toqqn&id='.$value['id'].'">'.$value['login'].'</a>';  
	  echo '</div>';
	}


$requete1 = $sql->select('MAX(chat.id) as dernier_id, chat.id_droit, droit.nom', 'chat', "LEFT JOIN `droit` ON (chat.id_droit = droit.id) GROUP BY `id_droit`"); 
$requete2 = $sql->select('MAX(chat.id) as dernier_id, chat.id_destinataire, utilisateur.login', 'chat', "LEFT JOIN `utilisateur` ON (chat.id_destinataire = utilisateur.id) GROUP BY `id_destinataire`"); 

$retour = array();
foreach($requete1 as $value)
{
  if(isset($value['nom']))
    $retour[$value['nom']] = $value['dernier_id'];
}
foreach($requete2 as $value)
{
  if($value['login'] != '' AND $value['id_destinataire'] != 0)
    $retour[$value['login']] = $value['dernier_id'];
}

echo '<pre>';
print_r($requete1);
echo '</pre>';

echo '<pre>';
print_r($requete2);
echo '</pre>';


echo '<pre>';
print_r($retour);
echo '</pre>';
*/
/*
$sql->update('cat_prob', "`nom` = 'Santé'", '`id`=3');
$sql->update('cat_prob', "`nom` = 'Sécurité'", '`id`=4');

$id = 14;
$resultat = $sql->select('nom','droit',"INNER JOIN liste_droit ON (liste_droit.id_droit=droit.id) WHERE liste_droit.id_utilisateur='".$id."'");

$droits = array();
if(array_key_exists('nom', $resultat))
{
  $droits[] = $resultat['nom'];
}
else
{
  foreach($resultat as $value)
  {
    $droits[] = $value['nom'];
  }
}


$_SESSION['droit'] = $droits;


echo '<pre>';
print_r($droits);
echo '</pre>';*/

?>


