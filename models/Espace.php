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

	public function espaceUserList() {
		$sth = $this->db->prepare('SELECT e.`id`, e.`nom`, `lieu`, `id_type_espace`, `id_utilisateur`, `etat`, u.login
			FROM `espace` e
			LEFT JOIN `utilisateur` u
				ON `id_utilisateur` = u.id
			ORDER BY `nom` ASC');
		$sth->execute();
		return $sth;
	}

}
