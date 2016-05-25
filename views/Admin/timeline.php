<?php

$interval = new DateInterval('PT15M');


// Generate table content
$table = [];
// Problems
foreach ($vars['problems'] as $problem) {
	$timestamp = (new DateTime($problem['heure']))->getTimestamp();
	$quarter = $timestamp - $timestamp%(15*60);
	if(!isset($table[$problem['id_espace']][$quarter][$timestamp])) {
		$table[$problem['id_espace']][$quarter][$timestamp] = '';
	}

	$class = '';
	switch($problem['gravite']) {
		case 0: $class = 'btn-success'; break;
		case 1: $class = 'btn-warning'; break;
		case 2: $class = 'btn-danger'; break;
	}
	$time = (new DateTime($problem['heure']))->format('H:i');

	$table[$problem['id_espace']][$quarter][$timestamp] .= '<span class="btn btn-default btn-problem '.$class.'" title="Problème signalé"><i class="glyphicon glyphicon-wrench"></i> '.$time.' '.$problem['nom'].'</span>';

}

// Flux entamés
foreach ($vars['fluxEntames'] as $flux) {
	$timestamp = (new DateTime($flux['entame']))->getTimestamp();
	$quarter = $timestamp - $timestamp%(15*60);

	if(!isset($table[$flux['id_espace']][$quarter][$timestamp])) {
		$table[$flux['id_espace']][$quarter][$timestamp] = '';
	}

	$time = (new DateTime($flux['entame']))->format('H:i');
	$table[$flux['id_espace']][$quarter][$timestamp] .= '<span class="btn btn-default btn-problem btn-warning" title="Fût entamé"><i class="glyphicon glyphicon-oil"></i> '.$time.' '.$flux['identifiant'].'</span>';

}
// Flux fins
foreach ($vars['fluxFins'] as $flux) {
	$timestamp = (new DateTime($flux['fin']))->getTimestamp();
	$quarter = $timestamp - $timestamp%(15*60);

	if(!isset($table[$flux['id_espace']][$quarter][$timestamp])) {
		$table[$flux['id_espace']][$quarter][$timestamp] = '';
	}

	$time = (new DateTime($flux['fin']))->format('H:i');
	$table[$flux['id_espace']][$quarter][$timestamp] .= '<span class="btn btn-default btn-problem btn-danger" title="Fût terminé"><i class="glyphicon glyphicon-oil"></i> '.$time.' '.$flux['identifiant'].'</span>';

}

// Parcours
foreach ($vars['parcours'] as $flux) {
	// debut
	$timestamp = (new DateTime($flux['debut']))->getTimestamp();
	$quarter = $timestamp - $timestamp%(15*60);

	if(!isset($table[$flux['id_espace']][$quarter][$timestamp])) {
		$table[$flux['id_espace']][$quarter][$timestamp] = '';
	}

	$time = (new DateTime($flux['debut']))->format('H:i');
	$table[$flux['id_espace']][$quarter][$timestamp] .= '<span class="btn btn-default btn-problem btn-primary" title="Arrivé d\'un fût déplacé vers cet espace"><i class="glyphicon glyphicon-log-in"></i> '.$time.' '.$flux['identifiant'].'</span>';

	// fin
	$timestamp = (new DateTime($flux['fin']))->getTimestamp();
	$quarter = $timestamp - $timestamp%(15*60);

	if(!isset($table[$flux['id_espace']][$quarter][$timestamp])) {
		$table[$flux['id_espace']][$quarter][$timestamp] = '';
	}

	$time = (new DateTime($flux['fin']))->format('H:i');
	$table[$flux['id_espace']][$quarter][$timestamp] .= '<span class="btn btn-default btn-problem btn-primary" title="Départ d\'un fût déplacé vers un autre espace"><i class="glyphicon glyphicon-log-out"></i> '.$time.' '.$flux['identifiant'].'</span>';

}

// Chat
foreach ($vars['messages'] as $message) {
	$timestamp = (new DateTime($message['date']))->getTimestamp();
	$quarter = $timestamp - $timestamp%(15*60);

	if(!isset($table[$message['id_espace']][$quarter][$timestamp])) {
		$table[$message['id_espace']][$quarter][$timestamp] = '';
	}

	$author = $message['author'];
	$style = 'color:black;';
	if(!empty($message['droit'])) {
		$style = 'color:red;';
		$author = $message['author'].'&nbsp;→&nbsp;'.$message['droit'];
	}

	$time = (new DateTime($message['date']))->format('H:i:s');
	$table[$message['id_espace']][$quarter][$timestamp] .= '
	<div class="chat-body clearfix"><span class="time">['.$time.']</span>&nbsp;<span style="font-weight:bold;'.$style.'">'.$author.'</span>:<br/>'.$message['message'].'
	</div>';
}


// Coin transfers
foreach ($vars['transfers'] as $transfer) {
	$timestamp = (new DateTime($transfer['transferredAt']))->getTimestamp();
	$quarter = $timestamp - $timestamp%(15*60);

	if(!isset($table[$transfer['espace_id']][$quarter][$timestamp])) {
		$table[$transfer['espace_id']][$quarter][$timestamp] = '';
	}

	$time = (new DateTime($transfer['transferredAt']))->format('H:i');
	$table[$transfer['espace_id']][$quarter][$timestamp] .= '<span class="btn btn-default btn-problem btn-info" title="Transfert de jetons"><i class="glyphicon glyphicon-transfer"></i> '.$time.' : <strong>'.$transfer['value'].'</strong></span>';

}


//structure de la page
$js = [];
$title = "Chronologie de la soirée";
?>
<div class="row admin chat">
	<div class="col-md-12">
		<div class="row espace">
			<div class="col-md-12">

				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="pull-right espace-btnbar">
							<form action="" method="get">
								<label><input type="checkbox" name="problems" <?= (isset($vars['filter']['problems'])?'checked':'') ?>> Problèmes</label>
								<label><input type="checkbox" name="flux" <?= (isset($vars['filter']['flux'])?'checked':'') ?>> Flux</label>
								<label><input type="checkbox" name="coins" <?= (isset($vars['filter']['coins'])?'checked':'') ?>> Jetons</label>
								<label><input type="checkbox" name="chat" <?= (isset($vars['filter']['chat'])?'checked':'') ?>> Chat</label>
								<select class="form-control input-sm" name="espace">
									<option value="0">Pas de filtrage</option>
									<?php
										foreach ($vars['espaces'] as $value) {
											if(!empty($vars['filter']['espace']) && $value['id'] == $vars['filter']['espace']) {
												echo '<option value="'. $value['id'] .'" selected>'.$value['nom'].'</option>';
											}
											else {
												echo '<option value="'. $value['id'] .'">'.$value['nom'].'</option>';
											}
										}
									?>
								</select>
								<input type="submit" value="Filtrer" class="btn btn-sm btn-primary"/>
								<a href="/admin" class="btn btn-sm btn-danger">Retour</a>
							</form>
						</div>
						<h3 class="panel-title">Chronologie de la soirée</h3>
					</div>
					<div class="table-panel-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Nom</th>

									<?php
										$cur = clone $conf['start'];
										while($cur < $conf['end']) {
											echo '<th>'.$cur->format('H:i').'</th>';
											$cur->add($interval);
										}
										?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($vars['espaces'] as $espace) {
									if(empty($vars['filter']['espace']) || $espace['id'] == $vars['filter']['espace']) {
									?>
									<tr>
										<th><a href="/admin#chat-user-<?= $espace['login'] ?>"><?= $espace['nom'] ?></a></th>
										<?php
											$cur = clone $conf['start'];
											$curEnd = (clone $conf['start'])->add($interval);
											$problemI = 0;
											while($cur < $conf['end']) {
												echo '<td title="'.$espace['nom'].' - '.$cur->format('H:i').'">';
													$ar = $table[$espace['id']][$cur->getTimestamp()] ?? [];
													ksort($ar);
													foreach ($ar as $value) {
														echo $value;
													}
												echo '</td>';

												$cur->add($interval);
												$curEnd->add($interval);
											}
									echo '</tr>';
									}
								}
							?>
							</tbody>
							<tfoot>
								<tr>
									<th>Nom</th>
									<?php
										$cur = clone $conf['start'];
										while($cur < $conf['end']) {
											echo '<th>'.$cur->format('H:i').'</th>';
											$cur->add(new DateInterval('PT15M'));
										}
										?>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
