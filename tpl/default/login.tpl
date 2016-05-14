<?php

/*
 * 
 * Auteur : Reivax <bernard.xav@gmail.com>
 * Modification : 24/04/09 par ReivaX
 * 
 * Description : Template de la page d'authentification
 * 
 */

//structure de la page
$Css = Array('style','login');
$Js = Array();
$NomPage = "Authentification";
?>

<?php include_once($config['tplServer'].'/header.inc'); ?>

<div class="login-all">

  <div class="info">
    <h1>Information&nbsp;</h1>
    <div class="centerLogin">
      <p id="img">A savoir&nbsp;:</p>
      <ol> 
        <li>Connectez-vous avec l'utilisateur et le mot de passe que le Gala vous a donné</li>
		<li>Si vous souhaitez avoir un acc&egrave;s, contactez l'équipe Gala</li>
        <li>En cas de problème, merci de contacter l'&eacute;quipe Gala</li> 
      </ol>
    </div>
  </div>

  <div class="login">
    <div class="top"><h1>Connexion &agrave; FluxManager</h1></div>
    <div id="centerLogin" class="formcontainer">
      <?php if(isset($_POST['utilisateur'])) { ?>
      <div class="erroLogin">Nom d'utilisateur ou mot de passe incorrect</div>
      <?php } ?>
      <div class="lbfieldstext">
        <p class="lbuser">Nom d'utilisateur&nbsp;:</p>
        <p class="lbpass">Mot de passe&nbsp;:</p>
      </div>
    
      <div class="login-fields">
        <form method="post" action="">
          <p>
            <input id="lbusername" name="utilisateur" class="defaultfocus" size="15" value="<?php if(isset($_POST['utilisateur'])) echo $_POST['utilisateur'] ?>" type="text"><br>
            <input id="lbpassword" name="password" size="15" type="password"><br>							
            <input class="loginsubmit" name="loginsubmit" value="Envoyer" type="submit">
			<input class="loginsubmit" name="efface" value="Effacer" type="reset" /> 
          </p>
        </form>
      </div>
    </div>
  </div>

</div>

<?php include_once($config['tplServer'].'/footer.inc'); ?>