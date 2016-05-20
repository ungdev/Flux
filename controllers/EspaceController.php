<?php

namespace controllers;
use InvalidArgumentException;
use models\User;
use models\Flux;
use models\Problem;
use models\Chat;

class EspaceController extends Controller
{

	public function homeAction() {
		if(!$this->login->isConnected() OR !$this->login->testDroit('Bar')) {
			return ['redirection' => ''];
		}

		return [
			'view' => 'Espace/home',
			'vars' => [
				'espaceName' => $_SESSION['nom_espace']
			],
		];

	}

	public function jsonAction() {
		if(!$this->login->isConnected() OR !$this->login->testDroit('Bar')) {
			return [
				'view' => 'errors/403'
			];
		}
		$problemModel = new Problem();
		$fluxModel = new Flux();
		$chatModel = new Chat();

		$userModel = new User();
		$userModel->updateLastConnection($_SESSION['id']);

		$json = [];
		$json['version'] = $this->conf['version'];
		$json['problemList'] = $problemModel->listForEspace($_SESSION['id_espace'])->fetchAll(\PDO::FETCH_ASSOC);
		$json['fluxList'] = $fluxModel->listForEspace($_SESSION['id_espace'])->fetchAll(\PDO::FETCH_ASSOC);
		$json['messageList'] = $chatModel->messageListForEspace($_SESSION['id'])->fetchAll(\PDO::FETCH_ASSOC);

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
