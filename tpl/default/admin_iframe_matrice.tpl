<?php

/*
 * 
 * Auteur : Reivax <bernard.xav@gmail.com>
 * Modification : 09/05/09 par SoX
 * 
 * Description : Template de l'administration
 * 
 */

//structure de la page
$Css = Array('style', 'admin');
$Js = Array('mootools', 'admin_iframe_matrice');
$NomPage = "Espace à thème";
?>

<?php include_once($config['tplServer'].'/header.inc'); ?>

<div>
	
<a href="#" onclick="parent.fullscreen();document.body.style.background='white';document.getElementById('mini').style.display='block';document.getElementById('full').style.display='none';" id="full">Plein ecran</a><a href="#" onclick="parent.minimize();document.body.style.background='transparent';document.getElementById('mini').style.display='none';document.getElementById('full').style.display='block';" style="display:none;" id="mini" >Minimize</a>

<select id="select_type_stock" name="id_type_stock"><?php echo $admin->retourneSelectTypeStock($Value['id_cat_prob']) ?></select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Deplacer la selecion vers : 
<select id="select_type_espace" name="id_espace"><?php echo $admin->retourneSelectSimulBar() ?></select>

<div id="div_table_stock"></div>

</div>

<?php include_once($config['tplServer'].'/footer.inc'); ?>
