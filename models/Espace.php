<?php

namespace models;

class Espace extends Model
{
	protected $db;
	protected $conf;

	public function espaceList() {
		$sth = $this->db->prepare('SELECT `id`, `nom`, `lieu`, `id_type_espace`, `id_utilisateur`, `etat` FROM `espace` ORDER BY `nom` ASC');
		$sth->execute();
		return $sth;
	}

}
