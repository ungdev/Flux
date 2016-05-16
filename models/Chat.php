<?php

namespace models;

class Chat extends Model
{
	protected $db;
	protected $conf;

	public function messageListForEspace($userId, $droitIdArray) {
		$in  = str_repeat('?,', count($droitIdArray) - 1) . '?';

		$sth = $this->db->prepare(
			'SELECT c.id, u.login, UNIX_TIMESTAMP(c.`date`) as date, c.message, d.nom as droit, IF(u.id = ?, TRUE, FALSE) as me
			FROM chat c
			LEFT JOIN utilisateur u
				ON (c.id_expediteur = u.id)
			LEFT JOIN droit d
				ON (c.id_droit = d.id)
			WHERE id_destinataire = ?
				OR id_expediteur = ?
				OR id_droit IN('.$in.')
			ORDER BY date ASC');

		$ar = $droitIdArray;
		array_unshift($ar, $userId, $userId, $userId);

		$sth->execute($ar);
		return $sth;
	}

	public function sendMessageFromEspace($userId, $message) {
		$sth = $this->db->prepare(
			'INSERT INTO `chat`(`id_expediteur`, `id_destinataire`, `id_droit`, `date`, `message`)
			VALUES (:author,null,null,NOW(),:message)');

		$sth->execute([
			':author' => $userId,
			':message' => htmlspecialchars($message),
		]);
		return $sth;
	}

}
