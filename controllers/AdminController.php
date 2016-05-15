<?php

namespace controllers;
use \lib\problemes;
use \lib\admin_administration;
use lib\admin_problemes;
use lib\admin_iframe_log;
use lib\admin_iframe_treso;
use lib\admin_iframe_matrice;

class AdminController extends Controller
{

	public function HomeAction() {

		if(!$this->login->isConnected() OR !$this->login->testDroit('admin')) {
			return ['redirection' => ''];
		}

		if(isset($_GET['action']) AND $_GET['action'] == 'aprob') {
			$prob = new problemes();
			$prob->prob_niveau($_GET['id'], $_GET['id_type'], $_GET['gravite'], -1);
			return ['redirection' => 'admin'];
		}

		return [
			'view' => 'Admin/home',
			'vars' => []
		];
	}

	public function AdministrationAction() {

		if(!$this->login->isConnected() OR !$this->login->testDroit('admin')) {
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

		if(!$this->login->isConnected() OR (!$this->login->testDroit('superadmin') AND !$this->login->testDroit('admin_stock'))) {
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

		if(!$this->login->isConnected() OR !$this->login->testDroit('admin')) {
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

		if(!$this->login->isConnected() OR (!$this->login->testDroit('superadmin') AND !$this->login->testDroit('admin_espaces'))) {
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

		if(!$this->login->isConnected() OR !$this->login->testDroit('superadmin')) {
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
		if(!$this->login->isConnected() OR (!$this->login->testDroit('logistique') AND !$this->login->testDroit('superadmin'))) {
			return ['redirection' => ''];
		}
		return [
			'view' => 'Admin/logContainer',
			'layout' => 'fragment'
		];
	}

	public function matriceContainerAction() {
		if(!$this->login->isConnected() OR !$this->login->testDroit('admin')) {
			return ['redirection' => ''];
		}
		return [
			'view' => 'Admin/matriceContainer',
			'layout' => 'fragment'
		];
	}

	public function tresoContainerAction() {
		if(!$this->login->isConnected() OR !($this->login->testDroit('superadmin') OR $this->login->testDroit('treso'))) {
			return ['redirection' => ''];
		}
		return [
			'view' => 'Admin/tresoContainer',
			'layout' => 'fragment'
		];
	}

	public function logAction() {

		if(!$this->login->isConnected() OR (!$this->login->testDroit('logistique') AND !$this->login->testDroit('superadmin'))) {
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

		if(!$this->login->isConnected() OR (!$this->login->testDroit('matrice') AND !$this->login->testDroit('superadmin'))) {
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

		if(!$this->login->isConnected() OR (!$this->login->testDroit('treso') AND !$this->login->testDroit('superadmin'))) {
			return ['redirection' => ''];
		}

		$admin = new admin_iframe_treso();

		// TODO move to view
		$admin->afficher_delestage();
		exit;

	}

	public function problemAction() {

		if(!$this->login->isConnected() OR !$this->login->testDroit('admin')) {
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
