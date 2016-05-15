<?php

namespace controllers;

class LoginController extends Controller
{

	public function loginAction() {

		// L'utilisateur vient de soumettre le formulaire, on vérifie s'il n'est pas
		// déjà connecté ou si
		if (array_key_exists('utilisateur', $_POST) && array_key_exists('password', $_POST)) {
			 if ($this->login->checkCredentials($_POST['utilisateur'], $_POST['password'])) {
				// Redirection vers la bonne page en fonction de ses droits.
				if ($this->login->testDroit('Admin')) {
					return ['redirection' => 'admin'];
				}
				elseif ($this->login->droitEspace()) {
					return ['redirection' => 'espace'];
				}
				else {
					return ['view' => 'errors/403'];
				}
			 }
		}

		return [
			'view' => 'Login/login',
			'vars' => []
		];
	}

	public function logoutAction() {
		unset($_SESSION);
		session_regenerate_id();
		session_destroy();

		return ['redirection' => ''];
	}
}
