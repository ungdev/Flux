<?php
//structure de la page
$css = ['bootstrap.min', 'bootstrap-theme.min', 'login'];
$js = ['jquery.min', 'bootstrap.min'];
$title = "Connexion";

?>
<div class="container">
	<form class="form-signin" method="post" action="">
		<h2 class="form-signin-heading"><?= $conf['app_name'] ?></h2>
		<?php if ($vars['error']) { ?>
			<div class="alert alert-danger" role="alert">Erreur dans l'identifiant ou le mot de passe</div>
		<?php } ?>
		<label for="inputLogin" class="sr-only">Identifiant</label>
		<input type="text" id="inputLogin" name="login" class="form-control" placeholder="Identifiant" required autofocus>
		<label for="inputPassword" class="sr-only">Mot de passe</label>
		<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Mot de passe" required>
		<input class="btn btn-lg btn-primary btn-block" type="submit" value="Se connecter"/>
	</form>
</div>
