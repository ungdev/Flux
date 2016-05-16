<?php

namespace models;

class Problem extends Model
{
	protected $db;
	protected $conf;

	public function listForEspace($espaceId) {
		$sth = $this->db->prepare(
			'SELECT t.id as id_type_prob, t.id_cat_prob, t.nom, l.id, l.gravite, c.nom as cat
			FROM type_prob t
			LEFT JOIN cat_prob c
				ON c.id = t.id_cat_prob
			LEFT JOIN liste_prob l
				ON l.id_type_prob = t.id
				AND l.id_espace = :id_espace
			WHERE c.id != 0
			ORDER BY id_cat_prob, id_type_prob ASC');
		$sth->execute(['id_espace' => $espaceId]);
		return $sth;
	}

	public function setProblem($espaceId, $typeId, $gravite) {

		// Try to find a problem that already exist for this espace
		$sth = $this->db->prepare(
			'SELECT id
			FROM liste_prob
			WHERE id_espace = :espaceId
				AND id_type_prob = :typeId');
		$sth->execute([
			':espaceId' => $espaceId,
			':typeId' => $typeId,
		]);
		$result = $sth->fetchAll(\PDO::FETCH_ASSOC);

		if(count($result) && isset($result[0]['id'])) {
			// Update
			$id = $result[0]['id'];
			$sth = $this->db->prepare('UPDATE `liste_prob` SET `gravite`=:gravite WHERE id=:id');
			$sth->execute([
				':gravite' => $gravite,
				':id' => $id,
			]);
		}
		else {
		// Insert
			$sth = $this->db->prepare(
			'INSERT INTO `liste_prob`(`id_type_prob`, `id_espace`, `gravite`, `auteur`)
			VALUES (:typeId,:espaceId,:gravite,NULL)');
			$sth->execute([
				':espaceId' => $espaceId,
				':typeId' => $typeId,
				':gravite' => $gravite,
			]);
			$id = $this->db->lastInsertId();
		}

		// Log
		$sthLog = $this->db->prepare(
		'INSERT INTO `archive_prob`(`id_liste_prob`, `id_type_prob`, `id_espace`, `heure`, `gravite`, `acteur`)
		VALUES (:id,:typeId,:espaceId,NOW(),:gravite,NULL)');
		$sthLog->execute([
			':id' => $id,
			':typeId' => $typeId,
			':espaceId' => $espaceId,
			':gravite' => $gravite,
		]);

		return $sth;
	}

}
