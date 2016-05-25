<?php

//structure de la page
$js = ['admin'];
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

		<!-- Panel used when on transfers click -->
		<div class="row espace" id="transfer">
			<div class="col-md-12">

				<div class="panel panel-default chat-panel">
					<div class="panel-heading">
						<div class="pull-right espace-btnbar">
							<select class="form-control input-sm filterSelect" id="transfer-filter">
								<option value="">Pas de filtrage</option>
							</select>
							<button data-toggle="modal" data-target="#transfer-from-modal" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Délestage de bar</button>
							<button data-toggle="modal" data-target="#transfer-to-modal" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Rechargement en jeton</button>
						</div>
						<h3 class="panel-title">Transfers de jeton</h3>
					</div>

					<div class="table-panel-body">
						<table class="table table-hover	">
							<thead>
								<tr>
									<th>Point de vente</th>
									<th>Transféré</th>
									<th>Compté</th>
									<th>Valeur</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="transfer-list">
							</tbody>
							<tfoot>
								<tr>
									<th colspan="3" style="text-align:right;">Jetons delestés : <br/>
									Jetons rechargés : <br/>
									Total : </th>
									<td colspan="2">
										<span id="transfer-credit"></span><br/>
										<span id="transfer-debit"></span><br/>
										<span id="transfer-sum"></span>
									</td>
								</tr>
							</tfoot>
						</table>
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
			<iframe class="iframe" src="admin_iframe_log"></iframe>
		</div>
		<!-- Stock panel -->
		<div class="row" id="stock">
			<iframe class="iframe" src="admin_iframe_matrice"></iframe>
		</div>
		<!-- Admin panel -->
		<div class="row" id="admin">
			<div class="col-md-3">
				<h4>Stock</h4>
				<iframe class="iframe" src="admin_stock"></iframe>
			</div>
			<div class="col-md-3">
				<h4>Problème</h4>
				<iframe class="iframe" src="admin_gestion_problemes"></iframe>
			</div>
			<div class="col-md-3">
				<h4>Espace</h4>
				<iframe class="iframe" src="admin_espaces"></iframe>
			</div>
			<div class="col-md-3">
				<h4>Utilisateur</h4>
				<iframe class="iframe" src="admin_utilisateurs"></iframe>
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
					<a href="/admin/timeline" class="btn btn-sm btn-success" title="Chronologie de la soirée"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></a>
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
						<a href="#transfer" class="list-group-item" data-btnname="transfer" data-panel="transfer">Jetons</a>
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

<!-- Coin create transfer from espaces -->
<div class="modal fade" id="transfer-from-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Délestage</h4>
			</div>
			<div class="modal-body">
				Veuillez selectionner les bars que vous venez de délester :
				<form action="/admin/transfer-from" method="post" id="transfer-from-form">
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Coin create transfer to an espace -->
<div class="modal fade" id="transfer-to-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Rechargement de jeton</h4>
			</div>
			<div class="modal-body">
				<form action="/admin/transfer-to" method="post" id="transfer-from-to">

					<div class="form-group">
						<label>
							Destinataire
							<select class="form-control" id="transfer-to-field" name="espaceId">
							</select>
						</label>
					</div>

					<div class="form-group">
						<label>
							Nombre de jetons donnés
							<input type="number" name="value" class="form-control"/>
						</label>
					</div>

					<input type="submit" value="Valider" class="btn btn-primary"/>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- Coin remove transfer -->
<div class="modal fade" id="transfer-remove-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Suppression d'un transfert</h4>
			</div>
			<div class="modal-body">
				<p>Confirmez vous la suppression du transfert ?</p>
				<form action="/admin/transfer-remove" method="post">
					<input type="hidden" name="id" id="transfer-remove-idfield">
					<button type="button" class="btn btn-danger" data-dismiss="modal" >Annuler</button>
					<input type="submit" value="Supprimer" class="btn btn-primary"/>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Coin edit transfer -->
<div class="modal fade" id="transfer-edit-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Modification du nombre de jetons d'un transfert</h4>
			</div>
			<div class="modal-body">
				<form action="/admin/transfer-edit" method="post">
					<div class="form-group">
						<label>Nombre de jetons
						<input type="number" class="form-control" id="transfer-edit-valueField" required name="value"></label>
						<br/><p>Note: Un délestage de bar sera écris avec un nombre positif<br/>tandis qu'un rechargement de point de vente sera écris en négatif</p>
					</div>
					<input type="hidden" name="id" id="transfer-edit-idfield">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
					<input type="submit" value="Modifier" class="btn btn-primary"/>
				</form>
			</div>
		</div>
	</div>
</div>
