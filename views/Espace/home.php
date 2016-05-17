<?php

//structure de la page
$js = ['espace'];
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
					<span class="connexionState">Pas encore mise à jour</span>
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
