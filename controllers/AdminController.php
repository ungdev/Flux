<?php

namespace controllers;
use models\Coin;
use models\Flux;
use models\User;
use models\Chat;
use models\Espace;
use models\Problem;

use \lib\admin_administration;
use lib\admin_iframe_log;
use lib\admin_iframe_matrice;

class AdminController extends Controller
{

	public function HomeAction() {

		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}

		return [
			'view' => 'Admin/home',
			'vars' => []
		];
	}


	public function JsonAction() {

		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return [
				'view' => 'errors/403'
			];
		}
		$chatModel = new Chat();
		$userModel = new User();

		$userModel->updateLastConnection($_SESSION['id']);

		$json = [];
		$json['version'] = $this->conf['version'];
		$json['timestamp'] =  (new \DateTime)->getTimestamp();
		$json['droitChannelList'] = $chatModel->droitChannelListForAdmin()->fetchAll(\PDO::FETCH_ASSOC);
		$json['espaceChannelList'] = $chatModel->espaceChannelListForAdmin()->fetchAll(\PDO::FETCH_ASSOC);

		if(isset($_GET['panel'])) {
			if($_GET['panel'] == 'chat-user' && !empty($_GET['id'])) {

				$problemModel = new Problem();
				$fluxModel = new Flux();

				$json['espace'] = $userModel->getEspace($_GET['id'])->fetch();
				$json['problemList'] = $problemModel->listForEspace($json['espace']['id'])->fetchAll(\PDO::FETCH_ASSOC);
				$json['fluxList'] = $fluxModel->listForEspace($json['espace']['id'])->fetchAll(\PDO::FETCH_ASSOC);
				$json['messageList'] = $chatModel->messageListForEspace($_GET['id'])->fetchAll(\PDO::FETCH_ASSOC);
			}
			else if($_GET['panel'] == 'chat-group' && !empty($_GET['id'])) {

				$json['messageList'] = $chatModel->droitMessageListForAdmin($_GET['id'])->fetchAll(\PDO::FETCH_ASSOC);
			}
			else if($_GET['panel'] == 'global-problems') {

				$problemModel = new Problem();
				$json['globalProblemList'] = $problemModel->listForAdmin()->fetchAll(\PDO::FETCH_ASSOC);
			}
			else if($_GET['panel'] == 'transfer') {

				$coinModel = new Coin();
				$espaceModel = new Espace();

				$json['espaceList'] = $espaceModel->espaceList()->fetchAll(\PDO::FETCH_ASSOC);

				if(!empty($_GET['id'])) {
					$json['transferList'] = $coinModel->transferList($_GET['id'])->fetchAll(\PDO::FETCH_ASSOC);
					$json['transferSum'] = $coinModel->transferSum($_GET['id'])->fetchAll(\PDO::FETCH_ASSOC);
				}
				else {
					$json['transferList'] = $coinModel->transferList()->fetchAll(\PDO::FETCH_ASSOC);
					$json['transferSum'] = $coinModel->transferSum()->fetchAll(\PDO::FETCH_ASSOC);
				}
			}
		}

		return [
			'layout' => 'fragment',
			'view' => 'json',
			'vars' => [ 'json' => $json ]
		];
	}

	public function chatSendAction() {
		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return [
				'view' => 'errors/403'
			];
		}
		$chatModel = new Chat();
		$json = [];


		if(!empty($_POST['message']) && !empty($_POST['target']) && !empty($_POST['panel'])) {
			if($_POST['panel'] == 'chat-user') {
				$chatModel->sendUserMessageFromAdmin($_SESSION['id'], $_POST['target'], $_POST['message']);
			}
			else if($_POST['panel'] == 'chat-group') {
				$chatModel->sendDroitMessageFromAdmin($_SESSION['id'], $_POST['target'], $_POST['message']);
			}
		}
		else {
			$json['error'] = 'Parameters is missing';
		}

		return [
			'layout' => 'fragment',
			'view' => 'json',
			'vars' => [ 'json' => $json ]
		];
	}


	public function setProblemAction() {
		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return [
				'view' => 'errors/403'
			];
		}

		if(empty($_GET['type']) || !isset($_GET['espace']) || !isset($_GET['gravite']) || !in_array($_GET['gravite'], ['0', '1', '2'])) {
			return [
				'view' => 'errors/403'
			];
		}

		$problemModel = new Problem();
		$problemModel->setProblem($_GET['espace'], $_GET['type'], $_GET['gravite']);

		return ['redirection' => 'admin#'.$_GET['btn']];
	}


	public function setItemAction() {
		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return [
				'view' => 'errors/403'
			];
		}

		$fluxModel = new Flux();

		// Check rights and if item is in espace
		if(empty($_GET['stock']) || !isset($_GET['espace']) || !isset($_GET['level']) || !in_array($_GET['level'], ['0', '1', '2'])
			|| !$fluxModel->isItemInEspace($_GET['stock'], $_GET['espace'])) {
			return [
				'view' => 'errors/403'
			];
		}

		// Set item level
		$fluxModel->setItemLevel($_GET['stock'], $_GET['level']);

		// Update manque auto
		$fluxModel->updateManqueAuto($_GET['stock'], $_GET['espace']);


		return ['redirection' => 'admin#'.$_GET['btn']];
	}



	public function toggleProgessAction() {
		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return [
				'view' => 'errors/403'
			];
		}

		$problemModel = new Problem();
		// Check rights and if item is in espace
		if(empty($_GET['id'])) {
			return [
				'view' => 'errors/403'
			];
		}

		// Set item in progress
		$problemModel->toggleInProgress($_GET['id']);

		return ['redirection' => 'admin#'.$_GET['btn']];
	}

	public function StockAction() {

		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}

		$admin = new admin_administration();
		$vars = [];


		if(isset($_POST['nom']))
		{
			//on enregistre
			$admin->enregistrer_type_stock($_POST['nom'], $_POST['reference'], $_POST['conditionnement'], $_POST['volume'], $_POST['valeur_achat'], $_POST['valeur_vente'], $_POST['unitaire'], $_POST['combien'], $_POST['id']);
		}
		elseif(isset($_GET['action']) AND $_GET['action'] == 'supprimer_type_stock')
		{
			$admin->supprimer_type_stock($_GET['id']);
		}
		elseif(isset($_GET['action']) AND $_GET['action'] == 'modifier_type_stock')
		{
			$vars['value'] = $admin->modifier_type_stock($_GET['id']);
		}

		$vars['admin'] = $admin;
		return [
			'view' => 'Admin/stock',
			'vars' => $vars
		];
	}

	public function ProblemManagerAction() {

		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}

		$admin = new admin_administration();
		$vars = [];

		if(isset($_POST['nom']))
		{
			//on enregistre
			$admin->enregistrer_type_prob($_POST['nom'], $_POST['id_cat_prob'], $_POST['lien'], $_POST['id']);
		}
		elseif(isset($_GET['action']) AND $_GET['action'] == 'supprimer_type_prob')
		{
			$admin->supprimer_type_prob($_GET['id']);
		}
		elseif(isset($_GET['action']) AND $_GET['action'] == 'modifier_type_prob')
		{
			$vars['value'] = $admin->modifier_type_prob($_GET['id']);
		}

		$vars['admin'] = $admin;
		return [
			'view' => 'Admin/problemManager',
			'vars' => $vars
		];
	}

	public function EspaceManagerAction() {

		if(!$this->login->isConnected() OR (!$this->login->testDroit('Admin'))) {
			return ['redirection' => ''];
		}

		$admin = new admin_administration();
		$vars = [];

		if(isset($_POST['nom']))
		{
			//on enregistre
			$admin->enregistrer_espace($_POST['nom'], $_POST['lieu'], $_POST['type_espace'], $_POST['utilisateur'], ($_POST['ouvert']??false), $_POST['id']);
		}
		elseif(isset($_GET['action']) AND $_GET['action'] == 'supprimer_espace')
		{
			$admin->supprimer_espace($_GET['id']);
		}
		elseif(isset($_GET['action']) AND $_GET['action'] == 'modifier_espace')
		{
			$vars['value'] = $admin->modifier_espace($_GET['id']);
		}


		$vars['admin'] = $admin;
		return [
			'view' => 'Admin/espaceManager',
			'vars' => $vars
		];
	}

	public function UserManagerAction() {

		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}

		$admin = new admin_administration();
		$vars = [];

		if(isset($_POST['login']))
		{
			//on enregistre
			$admin->enregistrer_utilisateur($_POST['login'], $_POST['password'], $_POST['id_utilisateur']);
		}
		elseif(isset($_POST['loginDroit']))
		{
			//on enregistre
			$admin->enregistrer_droit($_POST['loginDroit'], $_POST['droit']);
		}
		elseif(isset($_GET['action']) AND $_GET['action'] == 'supprimer_utilisateur')
		{
			$admin->supprimer_utilisateur($_GET['id']);
		}
		elseif(isset($_GET['action']) AND $_GET['action'] == 'modifier_utilisateur')
		{
			$vars['value'] = $admin->modifier_utilisateur($_GET['id']);
		}
		elseif(isset($_GET['action']) AND $_GET['action'] == 'supprimer_droit')
		{
			$vars['value'] = $admin->supprimer_droit($_GET['id']);
		}

		$vars['admin'] = $admin;
		return [
			'view' => 'Admin/userManager',
			'vars' => $vars
		];
	}

	public function logAction() {

		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}

		$admin = new admin_iframe_log();

		// TODO move to view
		if(isset($_GET['action']) AND $_GET['action'] == 'table_stock')
		{
			if(isset($_GET['id_stock'])){
				$admin->table_stock('stock', $_GET['id_stock']);
			} else {
				$admin->table_stock('espace', $_GET['id_espace']);
			}
			exit;
		}
		elseif(isset($_GET['action']) AND $_GET['action'] == 'bouger_stock')
		{
			$admin->tr_stock($_GET['id_stock'], $_GET['id_espace']);
			exit;
		}

		return [
			'view' => 'Admin/log',
			'vars' => [
				'admin' => $admin
			],
		];
	}

	public function matriceAction() {

		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}

		$admin = new admin_iframe_matrice();

		// TODO move to view
		if(isset($_GET['action']) AND $_GET['action'] == 'table_stock')
		{
			if(isset($_GET['id_stock'])){
				$admin->table_stock($_GET['id_stock']);
			}
			exit;
		}
		elseif(isset($_GET['action']) AND $_GET['action'] == 'bouger_stock')
		{
			$admin->tr_stock($_GET['id_stock'], $_GET['id_espace']);
			exit;
		}

		return [
			'view' => 'Admin/matrice',
			'vars' => [
				'admin' => $admin
			],
		];
	}



	public function createTransferFromAction() {

		if(!$this->login->isConnected() || !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}

		if(isset($_POST['espace']) && count($_POST['espace']) > 0) {
			$coinModel = new Coin();
			$coinModel->createMultipleTransfers($_SESSION['id'], $_POST['espace']);
		}

		return ['redirection' => 'admin#transfer'];
	}

	public function createTransferToAction() {

		if(!$this->login->isConnected() || !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}

		if(!empty($_POST['espaceId']) && !empty($_POST['value'])) {
			$coinModel = new Coin();
			$coinModel->createCountedTransfers($_SESSION['id'], $_POST['espaceId'], -abs($_POST['value']));
		}

		return ['redirection' => 'admin#transfer'];
	}

	public function removeTransferAction() {

		if(!$this->login->isConnected() || !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}

		if(!empty($_POST['id'])) {
			$coinModel = new Coin();
			$coinModel->softRemoveTransfer($_POST['id']);
		}

		return ['redirection' => 'admin#transfer'];
	}

	public function editTransferAction() {

		if(!$this->login->isConnected() || !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}

		if(!empty($_POST['id']) && !empty($_POST['value'])) {
			$coinModel = new Coin();
			$coinModel->updateTransfer($_POST['id'], $_POST['value'], $_SESSION['id']);
		}

		return ['redirection' => 'admin#transfer'];
	}
}
