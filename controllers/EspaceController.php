<?php

namespace controllers;
use InvalidArgumentException;
use lib\Chat;
use lib\flux;
use lib\problemes;
use lib\delestage;

class EspaceController extends Controller
{

	public function homeAction() {
		if(!$this->login->isConnected()) {
			return ['redirection' => ''];
		}

		$flux = new flux();
		$prob = new problemes();
		$chat = new Chat();

		if(isset($_GET['action']) AND $_GET['action'] == 'prob')
		{
			$prob->prob_niveau($_POST['id'], $_POST['id_type'], $_POST['gravite'], 1);
			header('Location: '.$this->conf['web_uri'].'espace');
		}
		elseif(isset($_GET['action']) AND $_GET['action'] == 'aprob')
		{
			$prob->prob_niveau($_GET['id'], $_GET['id_type'], $_GET['gravite'], -1);
			header('Location: '.$this->conf['web_uri'].'espace');
		}
		elseif(isset($_GET['action']) AND $_GET['action'] == 'flux')
		{
			$flux->stock_niveau($_POST['id_stock'],$_POST['id_espace'], 1);
			header('Location: '.$this->conf['web_uri'].'espace');
		}
		elseif(isset($_GET['action']) AND $_GET['action'] == 'aflux')
		{
			$flux->stock_niveau($_GET['id'],$_GET['id_espace'], -1);
			header('Location: '.$this->conf['web_uri'].'espace');
		}
		elseif(isset($_GET['action']) AND $_GET['action'] == 'delestage')
		{
			$delestage = new delestage();
			$delestage->traite_form($_POST['login_delestage'], $_POST['password_delestage'], $_POST['nb_jetons']);
		}

		return [
			'view' => 'Espace/home',
			'vars' => [
				'problemes' => $prob,
				'flux' => $flux,
				'chat' => $chat,
			],
		];

	}

	public function chatAction() {
		if(!$this->login->isConnected()) {
			return ['redirection' => ''];
		}
		$chat = new Chat();

		//si on vient du form
		if (array_key_exists('text_chat', $_POST)) {
			$liste = (isset($_GET['liste']))?$_GET['liste']:'';
			$id = (isset($_GET['id']))?$_GET['id']:'';
			$chat->enregistrer_message($liste, $id);
		}

		// On évite d'afficher une erreur de type notice suite à un éventuel switch sur
		// un index qui n'existe pas.
		if (!array_key_exists('action', $_GET)) {
		    $chat->afficheChat();
		} else {
			switch ($_GET['action']) {
					case 'liste_connectes':
					$chat->encore_connecte();
					break;

				case 'liste_messages':
					$chat->liste_messages();
					break;

				case 'id_dernier_message':
					$chat->Json_id_dernier_message();
					break;

				case 'toliste':
					if (!array_key_exists('id', $_GET)) {
					  throw new InvalidArgumentException('Pas de valeur `id` pour Chat::liste_messages_toliste(id)');
					}
					$chat->liste_messages_toliste($_GET['id']);
					break;

				case 'toqqn':
					if (!array_key_exists('id', $_GET)) {
					  throw new InvalidArgumentException('Pas de valeur `id` pour Chat::liste_messages_toqqn(id)');
					}
					$chat->liste_messages_toqqn($_GET['id']);
					break;

				case 'rappel_connexion':
					$chat->rappel_connexion();
					break;

				default:
					$chat->afficheChat();
			}

			// TODO put view stuff view
			exit;
		}

	}
}
