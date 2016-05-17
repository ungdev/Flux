<?php

namespace models;

class Chat extends Model
{
	protected $db;
	protected $conf;

	public function messageListForEspace($userId) {

		$sth = $this->db->prepare(
			'SELECT c.id, u.login, UNIX_TIMESTAMP(c.`date`) as date, c.message, d.nom as droit, IF(u.id = :userId, TRUE, FALSE) as me
			FROM chat c
			LEFT JOIN utilisateur u
				ON (c.id_expediteur = u.id)
			LEFT JOIN droit d
				ON (c.id_droit = d.id)
			WHERE id_destinataire = :userId
				OR id_expediteur = :userId
				OR id_droit IN(SELECT l.id_droit FROM liste_droit l WHERE l.id_utilisateur = :userId)
			ORDER BY date ASC');

		$sth->execute([
			':userId' => $userId
		]);
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


	public function droitChannelListForAdmin() {
		$sth = $this->db->prepare(
			'SELECT d.id, d.nom, c1.id as messageId, c1.id_expediteur as messageAuthorId
			FROM droit d
			LEFT JOIN chat c1
				ON (c1.id_droit = d.id)
			LEFT OUTER JOIN chat c2
				ON (d.id = c2.id_droit AND (c1.id < c2.id))
			WHERE
				c2.id IS NULL
				AND liste = 1
			ORDER BY nom');
		$sth->execute();
		return $sth;
	}

	public function espaceChannelListForAdmin() {
		$sth = $this->db->prepare(
			'SELECT u.id, login, UNIX_TIMESTAMP(`derniere_connexion`) as derniere_connexion, c1.id as messageId, c1.id_expediteur as messageAuthorId, e.nom
				FROM espace
				INNER JOIN utilisateur u
				ON (espace.id_utilisateur = u.id)
				LEFT JOIN chat c1
					ON (c1.id_destinataire = u.id OR c1.id_expediteur = u.id)
				LEFT OUTER JOIN chat c2
					ON ((c2.id_destinataire = u.id OR c2.id_expediteur = u.id) AND (c1.id < c2.id))
				LEFT JOIN espace e
					ON e.id_utilisateur = u.id
				WHERE
					c2.id IS NULL
				ORDER BY `login`');
		$sth->execute();
		return $sth;
	}

	public function sendUserMessageFromAdmin($fromId, $toId, $message) {
		$sth = $this->db->prepare(
			'INSERT INTO `chat`(`id_expediteur`, `id_destinataire`, `id_droit`, `date`, `message`)
			VALUES (:author,:dest,null,NOW(),:message)');

		$sth->execute([
			':author' => $fromId,
			':dest' => $toId,
			':message' => htmlspecialchars($message),
		]);
		return $sth;
	}

	public function sendDroitMessageFromAdmin($fromId, $droitId, $message) {
		$sth = $this->db->prepare(
			'INSERT INTO `chat`(`id_expediteur`, `id_destinataire`, `id_droit`, `date`, `message`)
			VALUES (:author,null,:droit,NOW(),:message)');

		$sth->execute([
			':author' => $fromId,
			':droit' => $droitId,
			':message' => htmlspecialchars($message),
		]);
		return $sth;
	}

	public function droitMessageListForAdmin($droitId) {

		$sth = $this->db->prepare(
			'SELECT c.id, u.login, UNIX_TIMESTAMP(c.`date`) as date, c.message, d.nom as droit
			FROM chat c
			LEFT JOIN utilisateur u
				ON (c.id_expediteur = u.id)
			LEFT JOIN droit d
				ON (c.id_droit = d.id)
			WHERE id_droit = :droitId
			ORDER BY date ASC');

		$sth->execute([
			':droitId' => $droitId
		]);
		return $sth;
	}
}
