<div class="row espace">

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
	<div class="col-md-4">

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
