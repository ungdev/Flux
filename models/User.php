<?php

namespace models;

class User extends Model
{
	protected $db;
	protected $conf;

	public function updateLastConnection($userId) {
		$sth = $this->db->prepare(
			'UPDATE `utilisateur` SET `derniere_connexion`= NOW() WHERE id = :userId');
		$sth->execute([':userId' => $userId]);
		return $sth;
	}

	public function getEspace($userId) {
		$sth = $this->db->prepare(
		'SELECT `login`, `pass`, `derniere_connexion`, e.id, e.nom, e.lieu, e.id_type_espace, e.etat, e.id_utilisateur
		FROM `utilisateur` u
		LEFT JOIN espace e
		ON u.id = e.id_utilisateur
		WHERE u.id = :userId
		GROUP BY u.id
		');
		$sth->execute([':userId' => $userId]);
		return $sth;
	}
}
