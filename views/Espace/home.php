<?php

//structure de la page
// $css = ['style', 'espace'];
$css = ['bootstrap.min', 'bootstrap-theme.min', 'style2'];
$js = ['jquery.min', 'bootstrap.min', 'espace'];
$title = "Espace à thème";
?>
<div class="row espace">

	<!-- Left sidebar : Problems -->
	<div class="col-md-3">

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Problèmes</h3>
			</div>
			<div class="panel-body" id="problems">
				Chargement..
			</div>
		</div>
	</div>
	<!-- Main panel : Flux -->
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="pull-right espace-btnbar">
					<span class="connexionState">Mise à jour : 12:23:32</span>
					<button data-toggle="modal" data-target="#help-modal" class="btn btn-sm btn-info"><span class=" glyphicon glyphicon-question-sign" aria-hidden="true"></span></button>
					<a href="/logout" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-off" aria-hidden="true"></span></a>
				</div>
				<h3 class="panel-title">Flux : <?= $vars['espaceName'] ?></h3>
			</div>
			<div class="panel-body" id="flux">
				Chargement..
			</div>
		</div>
	</div>
	<!-- Richt sidebar : Chat -->
	<div class="col-md-3">

		<div class="panel panel-default" id="chat-panel">
			<div class="panel-heading">
				<h3 class="panel-title">Communication</h3>
			</div>
				<div class="panel-body chat-panel-body">
					<ul class="chat" id="chat">
						Chargement..
					</ul>
				</div>
				<div class="panel-footer">
					<div class="input-group">
						<input id="btn-input" type="text" class="form-control input-sm" placeholder="Entrez votre message ici.."  maxlength="500"/>
						<span class="input-group-btn">
							<button class="btn btn-primary btn-sm" id="btn-chat">
							Envoyer</button>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="help-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Aide</h4>
			</div>
			<div class="modal-body">
				<h3>Colonne de gauche : Problèmes</h3>
				<ul>
					<li>Te permets de signaler les problémes survenant dans l'EàT.</li>
					<li>Un click = problème venant de survenir = bouton orange.</li>
					<li>Second click = problème sur-urgent ! = bouton rouge.</li>
					<li>Une fois, le problème résolu, clique sur le bouton vert pour signaler sa résolution.</li>
				</ul>
				<h3>Colonne du milieu : Stock</h3>
				<ul>
					<li>Ca correspond au stock réel de votre EàT.</p>
					<li>A chaque ouverture d'un produit : un click. Le bouton devient jaune.</li>
					<li>A chaque produit fini : un click. Le bouton devient rouge.</li>
					<li>Le bouton vert permet de revenir en arrière en cas d'erreur.</li>
				</ul>
				<h3>Colonne de droite : Chat</h3>
				<ul>
					<li>A surveiller pendant la soirée.</p>
					<li>C'est grâce à cela que les orga vous feront passer des messages.</li>
					<li>Merci de l'utiliser qu'en cas de besoin uniquement (précision de problème par exemple).</li>
					<li>CA N'EST PAS LA PEINE D'ECRIRE UN PROBLEME QUE VOUS VENEZ DE SIGNALER. MERCI.</li>
				</ul>
			</div>
		</div>
	</div>
</div>




<?php /*

		<div id="probleme">
			<div class="info"><h1>Problèmes</h1></div>
			<div class="bloc_probleme">
<?php $vars['problemes']->liste(); ?>
		</div>
		<!--<div id="delestage">
					<div class="info" id="h1_delestage"><h1>Délestage</h1></div>
				<div id="bloc_delestage">
				<form id="form_delestage" method="post" action="?action=delestage">
<?php //include_once($conf['server_path'].'lib/action/delestage.php'); ?>
				</form>
			</div>
		</div>-->
	</div>

		<div id="chat">
			<div class="top"><h1>Communication</h1></div>
			<?php

			// On évite d'afficher une erreur de type notice suite à un éventuel switch sur
			// un index qui n'existe pas.
			if (!array_key_exists('action', $_GET)) {
				$vars['chat']->afficheChat();
			} else {
				switch ($_GET['action']) {
						case 'liste_connectes':
						$vars['chat']->encore_connecte();
						break;

					case 'liste_messages':
						$vars['chat']->liste_messages();
						break;

					case 'id_dernier_message':
						$vars['chat']->Json_id_dernier_message();
						break;

					case 'toliste':
						if (!array_key_exists('id', $_GET)) {
						  throw new InvalidArgumentException('Pas de valeur `id` pour Chat::liste_messages_toliste(id)');
						}
						$vars['chat']->liste_messages_toliste($_GET['id']);
						break;

					case 'toqqn':
						if (!array_key_exists('id', $_GET)) {
						  throw new InvalidArgumentException('Pas de valeur `id` pour Chat::liste_messages_toqqn(id)');
						}
						$vars['chat']->liste_messages_toqqn($_GET['id']);
						break;

					case 'rappel_connexion':
						$vars['chat']->rappel_connexion();
						break;

					default:
						$vars['chat']->afficheChat();
				}
			}
				?>
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
				<li class="logout-icon"><a href="<?php echo $conf['web_uri']?>logout" title="Déconnexion"></a></li>
		</ul></div>
			<div class="center"><h1>Espace de <?php echo $_SESSION['login'] ?></h1></div>
			<div id="help">
			</div>
			<div class="bloc_flux">
				<form method="post" action="?action=flux">
				<?php $vars['flux']->liste($_SESSION['id_espace']); ?>
			</form>
		</div>
	</div>

*/?>
