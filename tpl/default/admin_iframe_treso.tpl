<?php

/*
 * 
 * Auteur : Theo <theophile.gurliat@gmail.com> le 15/05/2011
 * 
 * 
 * Description : Template de l'administration
 * 
 */

//structure de la page
$Css = Array('style', 'admin');
$Js = Array('mootools', 'admin_iframe_treso');
$NomPage = "Treso";
?>

<?php include_once($config['tplServer'].'/header.inc'); ?>

<div>
	
<a href="#" onclick="parent.fullscreen();document.body.style.background='white';document.getElementById('mini').style.display='block';document.getElementById('full').style.display='none';" id="full">Plein ecran</a><a href="#" onclick="parent.minimize();document.body.style.background='transparent';document.getElementById('mini').style.display='none';document.getElementById('full').style.display='block';" style="display:none;" id="mini" >Minimize</a>

<p id="reload_page_log"><a id="a_reload_page_log" href="">recharger</a></p>

<div id="div_table_stock"></div>
bla
</div>

<?php include_once($config['tplServer'].'/footer.inc'); ?>