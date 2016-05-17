<?php

//structure de la page
$css = ['bootstrap.min', 'bootstrap-theme.min', 'style2'];
$js = ['jquery.min', 'bootstrap.min', 'admin'];
$title = "Panneau d'admin";
?>
<div class="row admin">
	<div class="col-md-9" id="panel-container">


		<!-- Panel used when on problem click -->
		<div class="row espace" id="global-problems">
			<div class="col-md-12">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Problèmes</h3>
					</div>
					<div class="panel-body" id="global-problems-container">
						Chargement..
					</div>
				</div>
			</div>
		</div>

		<!-- Panel used when on chat-group click -->
		<div class="row espace" id="chat-group">
			<div class="col-md-12">

				<div class="panel panel-default chat-panel">
					<div class="panel-heading">
						<h3 class="panel-title">Communication</h3>
					</div>
					<div class="panel-body chat-panel-body">
						<ul class="chat">
							Chargement..
						</ul>
					</div>
					<div class="panel-footer">
						<div class="input-group">
							<input type="text" class="form-control input-sm" placeholder="Entrez votre message ici.."  maxlength="500"/>
							<span class="input-group-btn">
								<button class="btn btn-primary btn-sm">
								Envoyer</button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Panel used when on chat-user click -->
		<div class="row espace" id="chat-user">
			<!-- Left sidebar : Problems -->
			<div class="col-md-4">
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
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title" id="flux-title">Flux</h3>
					</div>
					<div class="panel-body" id="flux">
						Chargement..
					</div>
				</div>
			</div>
			<!-- Richt sidebar : Chat -->
			<div class="col-md-4">

				<div class="panel panel-default chat-panel">
					<div class="panel-heading">
						<h3 class="panel-title">Communication</h3>
					</div>
					<div class="panel-body chat-panel-body">
						<ul class="chat">
							Chargement..
						</ul>
					</div>
					<div class="panel-footer">
						<div class="input-group">
							<input type="text" class="form-control input-sm" placeholder="Entrez votre message ici.."  maxlength="500"/>
							<span class="input-group-btn">
								<button class="btn btn-primary btn-sm">
								Envoyer</button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>


		<!-- logistique panel -->
		<div class="row" id="logistique">
			<iframe id="iframe_admin" class="iframe_admin" src="admin_iframe_log" height="500" width="100%"></iframe>
		</div>
		<!-- Stock panel -->
		<div class="row" id="stock">
			<iframe id="iframe_admin" class="iframe_admin" src="admin_iframe_matrice" height="500" width="100%"></iframe>
		</div>
		<!-- Admin panel -->
		<div class="row" id="admin">
			<div class="col-md-3">
				<h4>Stock</h4>
				<iframe src="admin_stock" height="500" width="100%"></iframe>
			</div>
			<div class="col-md-3">
				<h4>Problème</h4>
				<iframe src="admin_gestion_problemes" height="500" width="100%"></iframe>
			</div>
			<div class="col-md-3">
				<h4>Espace</h4>
				<iframe src="admin_espaces" height="500" width="100%"></iframe>
			</div>
			<div class="col-md-3">
				<h4>Utilisateur</h4>
				<iframe src="admin_utilisateurs" height="500" width="100%"></iframe>
			</div>
		</div>

	</div>
	<!-- Richt sidebar : channel list -->
	<div class="col-md-3">

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="pull-right espace-btnbar">
					<span class="connexionState">Pas encore mise à jour</span>
					<button data-toggle="modal" data-target="#help-modal" class="btn btn-sm btn-info"><span class=" glyphicon glyphicon-question-sign" aria-hidden="true"></span></button>
					<a href="/logout" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-off" aria-hidden="true"></span></a>
				</div>
				<h3 class="panel-title">&nbsp;</h3>
			</div>
				<div class="panel-body" id="panel-menu">
					<div class="list-group">
						<a href="#global-problems" class="list-group-item" data-btnname="global-problems" data-panel="global-problems">Liste des problèmes</a>
						<a href="#logistique" class="list-group-item" data-btnname="logistique" data-panel="logistique">Logistique</a>
						<a href="#stock" class="list-group-item" data-btnname="stock" data-panel="stock">Etat du stock</a>
						<a href="#admin" class="list-group-item" data-btnname="admin" data-panel="admin">Administration</a>
					</div>
					<h4>Chat</h4>
					<div id="channels">Chargement..</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Help modal -->
<div class="modal fade" id="help-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Aide</h4>
			</div>
			<div class="modal-body">
				<h3>Todo</h3>
				<ul>
					<li>Rédiger l'aide</li>
					<li>Appelez moi Alabate !</li>
				</ul>
			</div>
		</div>
	</div>
</div>
