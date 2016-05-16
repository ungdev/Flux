<?php

namespace models;
use lib\DB;

class Model
{
	protected $db;
	protected $conf;
	protected $table;

	public function __construct() {
		global $conf;
		$this->db = new DB();
		$this->conf = $conf;
		$this->table = null;
	}

}
