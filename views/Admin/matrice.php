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
$css = ['style', 'admin'];
$js = ['mootools', 'admin_iframe_matrice'];
$title = "Espace à thème";
?>

<div>

<a href="#" onclick="parent.fullscreen();document.body.style.background='white';document.getElementById('mini').style.display='block';document.getElementById('full').style.display='none';" id="full">Plein ecran</a><a href="#" onclick="parent.minimize();document.body.style.background='transparent';document.getElementById('mini').style.display='none';document.getElementById('full').style.display='block';" style="display:none;" id="mini" >Minimize</a>

<select id="select_type_stock" name="id_type_stock"><?php echo $vars['admin']->retourneSelectTypeStock($vars['value']['id_cat_prob']??'') ?></select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Deplacer la selecion vers :
<select id="select_type_espace" name="id_espace"><?php echo $vars['admin']->retourneSelectSimulBar() ?></select>

<div id="div_table_stock"></div>

</div>
