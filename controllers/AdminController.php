<?php

namespace controllers;
use models\Flux;
use models\User;
use models\Chat;
use models\Problem;

use \lib\problemes;
use \lib\admin_administration;
use lib\admin_problemes;
use lib\admin_iframe_log;
use lib\admin_iframe_treso;
use lib\admin_iframe_matrice;

class AdminController extends Controller
{

	public function HomeAction() {

		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}
		//
		// if(isset($_GET['action']) AND $_GET['action'] == 'aprob') {
		// 	$prob = new problemes();
		// 	$prob->prob_niveau($_GET['id'], $_GET['id_type'], $_GET['gravite'], -1);
		// 	return ['redirection' => 'admin'];
		// }



		return [
			'view' => 'Admin/home2',
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

	public function AdministrationAction() {

		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}

		$admin = new admin_administration();

		// if(isset($_POST['login']))
		// {
		// 	$admin->enregistrer_utilisateur($_POST['login'], $_POST['password'], $_POST['droit']);
		// }
		// elseif(isset($_GET['action']) AND $_GET['action'] == 'liste_utilisateurs')
		// {
		// 	$admin->liste_utilisateurs();
		// }
		// elseif(isset($_GET['action']) AND $_GET['action'] == 'liste_supprimer_utilisateur')
		// {
		// 	$admin->liste_supprimer_utilisateur($_GET['id']);
		// }

		return [
			'view' => 'Admin/administration',
			'vars' => [],
			'layout' => 'fragment'
		];
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

	public function logContainerAction() {
		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}
		return [
			'view' => 'Admin/logContainer',
			'layout' => 'fragment'
		];
	}

	public function matriceContainerAction() {
		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}
		return [
			'view' => 'Admin/matriceContainer',
			'layout' => 'fragment'
		];
	}

	public function tresoContainerAction() {
		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}
		return [
			'view' => 'Admin/tresoContainer',
			'layout' => 'fragment'
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

	public function tresoAction() {

		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}

		$admin = new admin_iframe_treso();

		// TODO move to view
		$admin->afficher_delestage();
		exit;

	}

	public function problemAction() {

		if(!$this->login->isConnected() OR !$this->login->testDroit('Admin')) {
			return ['redirection' => ''];
		}

		$admin_problemes = new admin_problemes();

		if(isset($_POST['auteur']))
		{
			$admin_problemes->enregistrerAuteur($_POST['id'], $_POST['auteur']);
		}

		// TODO move to view
		$admin_problemes->liste();
		exit;
	}
}
