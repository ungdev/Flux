<?php

/*
 * 
 * Auteur : Reivax <bernard.xav@gmail.com>
 * Modification : 27/04/09 par SoX
 * 
 * Description : Template des espace a themes
 * 
 */

//structure de la page
$Css = Array('style', 'espace');
$Js = Array('mootools', 'chat');
$NomPage = "Espace à thème";
?>

<?php include_once($config['tplServer'].'/header.inc'); ?>

    <div id="probleme">
    	<div class="info"><h1>Problèmes</h1></div>
    	<div class="bloc_probleme">
<?php include_once($config['libServer'].'/action/problemes.php'); ?>
		</div>
		<!--<div id="delestage">
          <div class="info" id="h1_delestage"><h1>Délestage</h1></div>
	      <div id="bloc_delestage">
		    <form id="form_delestage" method="post" action="?action=delestage">
<?php //include_once($config['libServer'].'/action/delestage.php'); ?>
		    </form>
		  </div>
		</div>-->
	</div>

    <div id="chat">
    	<div class="top"><h1>Communication</h1></div>
    	<?php include_once($config['libServer'].'/action/chat.php'); ?>
	</div>

	<script>
		var i = 1;
		function displayHelp() {
			if (i == 1) {
				document.getElementById('help').style.display = 'block';
			} else {
				document.getElementById('help').style.display = 'none';
			}
			i = (i * -1);
		}
	</script>

    <div id="flux">
	  <div id="nav-icons_all"><ul id="nav-icons">
	  	<li class="help-icon"><a href="javascript:displayHelp()" title="Aide"></a></li>
        <li class="logout-icon"><a href="<?php echo $config['baseDir']?>/deconnexion" title="Déconnexion"></a></li>
	  </ul></div>
      <div class="center"><h1>Espace de <?php echo $_SESSION['login'] ?></h1></div>
      <div id="help">
      	<p id="pHelp"><a href="javascript:displayHelp()">X</a></p>
      	<h1>Aide</h1>
      	<h2>Colonne de gauche</h2>
      	<h3>Problèmes</h3>
      	  <p>Te permets de signaler les problémes survenant dans l'EàT.</p>
      	  <p>Un click = problème venant de survenir = bouton jaune.</p>
      	  <p>Second click = problème sur-urgent ! = bouton rouge.</p>
      	  <p>Une fois, le problème résolut, c'est à toi de cliquez sur la virgule verte pour signaler sa résolution.</p>
      	<h3>Délestage</h3>
      	  <p>Pas touche !</p>
      	  <p>Cette zone est réservée au responsable du délestage qui passera régulièrement durant la soirée.</p>
      	<h2>Colonne du milieu</h2>
      	<h3>Stock</h3>
      	  <p>Ca correspond au stock réel de votre EàT. Cette colonne sera donc mis à jour automatiquement au cours de la soirée.</p>
      	  <p>A chaque ouverture d'un produit : un click. Le bouton devient jaune.</p>
      	  <p>A chaque produit fini : un click. Le bouton devient rouge.</p>
      	  <p>La flèche verte permet de revenir en arrière en cas d'erreur.</p>
      	<h2>Colonne de droite</h2>
      	<h3>Chat</h3>
      	  <p>A surveiller pendant la soirée.</p>
      	  <p>C'est grâce à cela que les orga vous feront passer des messages.</p>
      	  <p>Merci de l'utiliser qu'en cas de besoin uniquement (précision de problème par exemple).</p>
      	  <p>CA N'EST PAS LA PEINE D'ECRIRE UN PROBLEME QUE VOUS VENEZ DE SIGNALER. MERCI.</p>
      </div>
      <div class="bloc_flux">
      	<form method="post" action="?action=flux">
<?php include_once($config['libServer'].'/action/flux.php'); ?>
		</form>
	  </div>
	</div>

<?php include_once($config['tplServer'].'/footer.inc'); ?>
