<?php

namespace controllers;

use \lib\Login;

class Controller
{
	protected $login;
	protected $conf;


	public function __construct() {
		global $conf;
		$this->login = new Login();
		$this->conf = $conf;
	}

}
