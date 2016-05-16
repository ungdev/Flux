<?php

namespace controllers;
use InvalidArgumentException;
use models\Flux;
use models\Problem;
use models\Chat;

class EspaceController extends Controller
{

	public function homeAction() {
		if(!$this->login->isConnected()) {
			return ['redirection' => ''];
		}

		return [
			'view' => 'Espace/home',
			'vars' => [
				'espaceName' => $_SESSION['nom_espace']
			],
		];

	}

	public function chatAction() {
		if(!$this->login->isConnected()) {
			return [
				'view' => 'errors/403'
			];
		}
		$chat = new \lib\Chat();

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

	public function jsonAction() {
		if(!$this->login->isConnected()) {
			return [
				'view' => 'errors/403'
			];
		}
		$problemModel = new Problem();
		$fluxModel = new Flux();
		$chatModel = new Chat();

		$json = [];
		$json['problemList'] = $problemModel->listForEspace($_SESSION['id_espace'])->fetchAll(\PDO::FETCH_ASSOC);
		$json['fluxList'] = $fluxModel->listForEspace($_SESSION['id_espace'])->fetchAll(\PDO::FETCH_ASSOC);
		$json['messageList'] = $chatModel->messageListForEspace($_SESSION['id'], $_SESSION['id_droit'])->fetchAll(\PDO::FETCH_ASSOC);

		return [
			'layout' => 'fragment',
			'view' => 'json',
			'vars' => [ 'json' => $json ]
		];
	}

	public function chatSendAction() {
		if(!$this->login->isConnected()) {
			return [
				'view' => 'errors/403'
			];
		}
		$chatModel = new Chat();
		$json = [];
		if(!empty($_POST['message'])) {
			$chatModel->sendMessageFromEspace($_SESSION['id'], $_POST['message']);
		}
		else {
			$json['error'] = 'Message is missing';
		}

		return [
			'layout' => 'fragment',
			'view' => 'json',
			'vars' => [ 'json' => $json ]
		];
	}

	public function setProblemAction() {
		if(!$this->login->isConnected()) {
			return ['redirection' => ''];
		}

		if(empty($_GET['type']) || !isset($_GET['gravite']) || !in_array($_GET['gravite'], ['0', '1', '2'])) {
			return [
				'view' => 'errors/403'
			];
		}

		$problemModel = new Problem();
		$problemModel->setProblem($_SESSION['id_espace'], $_GET['type'], $_GET['gravite']);

		return ['redirection' => 'espace'];
	}

	public function setItemAction() {
		if(!$this->login->isConnected()) {
			return ['redirection' => ''];
		}

		$fluxModel = new Flux();

		// Check rights and if item is in espace
		if(empty($_GET['stock']) || !isset($_GET['level']) || !in_array($_GET['level'], ['0', '1', '2'])
			|| !$fluxModel->isItemInEspace($_GET['stock'], $_SESSION['id_espace'])) {
			return [
				'view' => 'errors/403'
			];
		}

		// Set item level
		$fluxModel->setItemLevel($_GET['stock'], $_GET['level']);

		// Update manque auto
		$fluxModel->updateManqueAuto($_GET['stock'], $_SESSION['id_espace']);


		return ['redirection' => 'espace'];
	}
}
