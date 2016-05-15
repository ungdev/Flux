<?php

/*
 *
 * Auteur : Reivax <bernard.xav@gmail.com>
 * Modification : 09/05/09 par SoX
 *
 * Description : Template de l'administration
 *
 */

//structure de la page
$css = ['style', 'admin'];
$js = ['mootools', 'chat', 'administration', 'json2', 'admin_iframe_log'];
$title = "Administration";
?>

<div id="chat">
	<div class="top"><h1>Communication</h1></div>
	<?php include_once($conf['server_path'].'views/fragments/chat.php'); ?>
</div>

<div id="flux">
	<div id="nav-icons_all">
		<ul id="nav-icons">
			<li class="logout-icon"><a href="<?php echo $conf['web_uri']?>logout" title="Déconnexion"></a></li>
		</ul>
	</div>
	<div class="center"><h1>Administration (<?php echo $_SESSION['login'] ?>)</h1></div>
	<div id="admin_problemes" class="off onglet"><h1><a class="a_onglet" href="admin_problemes" title="Problèmes">Problèmes</a></h1></div>

	<?php if($login->testDroit('Admin')) { ?>
		<div id="admin_logistique" class="off onglet"><h1><a class="a_onglet" href="admin_logistique" title="Logistique">Logistique</a></h1></div>
	<?php } ?>

	<?php if($login->testDroit('Admin')) { ?>
		<div id="admin_matrice" class="off onglet"><h1><a class="a_onglet" href="admin_matrice" title="Logistique">Stock</a></h1></div>
	<?php } ?>

	<?php if($login->testDroit('Admin')) { ?>
		<div id="admin_tresorerie" class="off onglet"><h1><a class="a_onglet" href="admin_tresorerie" title="Trésorerie">Trésorerie</a></h1></div>
	<?php } ?>

	<?php if($login->testDroit('Admin')) { ?>
		<div id="admin_administration" class="off onglet"><h1><a class="a_onglet" href="admin_administration" title="Administration">Admin</a></h1></div>
	<?php } ?>

	<div id="onglet_chat" class="off onglet"><h1><a id="a_onglet_chat" href="" title="Chat">Chat</a></h1></div>

	<div id="corps">
		<div id="fenetre_chat">
			<div id="div_messages">Selectionner qurlzz</div>
			<form id="form_chat" method="POST" action="" autocomplete="off">
				<input type="text" id="text_chat_admin" name="text_chat" />
				<!--<textarea id="text_chat_admin" name="text_chat"></textarea>-->
				<div style="display:none"><input id="submit_form" type="submit" value="Envoyer" /></div>
			</form>
		</div>

		<div id="contenu">
			<h2>Bonjour et bienvenue sur l'administration du Flux Manager.</h2><br />
			<p>Cliquez sur un des onglets ci-dessus pour commencer.</p><br />
			<p>Pour commencer par un chat, cliquez sur une liste ou un contact dans la liste de droite.</p><br />
		</div>
	</div>
