<?php

namespace controllers;

class LoginController extends Controller
{

	public function loginAction() {

		// If form is submitted
		$error = false;
		if (!empty($_POST['login']) && !empty($_POST['password'])) {
			if ($this->login->checkCredentials($_POST['login'], $_POST['password'])) {

				// Redirect according to rights
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
			else {
				$error = true;
			}
		}

		return [
			'view' => 'Login/login',
			'vars' => [
				'error' => $error
			]
		];
	}

	public function logoutAction() {
		unset($_SESSION);
		session_regenerate_id();
		session_destroy();

		return ['redirection' => ''];
	}
}
