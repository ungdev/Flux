<?php

namespace models;

class Flux extends Model
{
	protected $db;
	protected $conf;

	public function listForEspace($espaceId) {
		$sth = $this->db->prepare(
			'SELECT t.nom as type_name, t.id as type_id, t.conditionnement as conditionnement, s.id, s.identifiant, UNIX_TIMESTAMP(s.entame) as entame, UNIX_TIMESTAMP(s.fin) as fin
			FROM `type_stock` t
			INNER JOIN stock s
				ON t.id = s.id_type_stock
			INNER JOIN parcours p
				ON s.id=p.id_stock
			WHERE p.id_espace = :id_espace
				AND p.fin=\'000-00-00 00:00:00\'
			GROUP BY p.id_stock
			ORDER BY t.nom, s.identifiant ASC');
		$sth->execute(['id_espace' => $espaceId]);
		return $sth;
	}

	public function isItemInEspace($stockId, $espaceId) {
		$sth = $this->db->prepare(
			'SELECT `id_espace` FROM `parcours` WHERE id_stock=:stockId ORDER BY id DESC LIMIT 1');
		$sth->execute(['stockId' => $stockId]);
		$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
		return (isset($result[0]['id_espace']) && $result[0]['id_espace'] == $espaceId);
	}

	public function setItemLevel($stockId, $level) {

		if($level == 0) {
			$sth = $this->db->prepare('UPDATE `stock` SET `entame`="0000-00-00 00:00:00", `fin`="0000-00-00 00:00:00" WHERE `id`=:id');
			$sth->execute([
				':id' => $stockId,
			]);
		}
		else if($level == 1) {
			$sth = $this->db->prepare('UPDATE `stock` SET `entame`=IF(entame="0000-00-00 00:00:00",NOW(),entame), `fin`="0000-00-00 00:00:00" WHERE `id`=:id');
			$sth->execute([
				':id' => $stockId,
			]);
		}
		else if($level == 2) {
			$sth = $this->db->prepare('UPDATE `stock` SET `entame`=IF(entame="0000-00-00 00:00:00",NOW(),entame), `fin`=NOW() WHERE `id`=:id');
			$sth->execute([
				':id' => $stockId,
			]);
		}

		return $sth;
	}

	/*
	 * Update manque auto problems
	 */
	public function updateManqueAuto($stockId, $espaceId) {
		// Find type stock informations
		$sth = $this->db->prepare(
			'SELECT s.`id_type_stock`, `identifiant`, `entame`, `fin`, `reste`, t.nom
			FROM `stock` s
			INNER JOIN type_stock t
				ON s.id_type_stock = t.id
			WHERE s.id = :stockId ');
		$sth->execute([
			':stockId' => $stockId
		]);
		$stock = $sth->fetch();

		// Calculate how many item left not open
		$sth = $this->db->prepare(
			'SELECT COUNT(s.id)
			FROM stock s
			JOIN parcours p1
				ON (p1.id_stock = s.id)
			LEFT OUTER JOIN parcours p2
				ON (s.id = p2.id_stock AND (p1.id < p2.id))
			WHERE
				p2.id IS NULL
				AND p1.id_espace=:espaceId
				AND s.id_type_stock=:stockTypeId
				AND s.entame="0000-00-00 00:00:00";');
		$sth->execute([
			':stockTypeId' => $stock['id_type_stock'],
			':espaceId' => $espaceId
		]);
		$manque = $sth->fetch()[0];

		// Find problem type
		$sth = $this->db->prepare(
			'SELECT `id`, `id_cat_prob`, `nom`, `lien`
			FROM `type_prob`
			WHERE lien=:stockTypeId');
		$sth->execute([
			':stockTypeId' => $stock['id_type_stock'],
		]);
		$result = $sth->fetch();
		if(!$result) {
			// The type doesn't exist, we create it
			$sth = $this->db->prepare(
				'INSERT INTO `type_prob`(`id_cat_prob`, `nom`, `lien`)
				VALUES (0,:nom,:stockTypeId)');
			$sth->execute([
				':nom' => $stock['nom'],
				':stockTypeId' => $stock['id_type_stock'],
			]);
			$id = $this->db->lastInsertId();
		}
		else {
			$id = $result['id'];
		}

		// Update problem
		$problemModel = new Problem();
		switch ($manque) {
			case 0:
				$problemModel->setProblem($espaceId, $id, 2);
				break;
			case 1:
				$problemModel->setProblem($espaceId, $id, 1);
				break;
			default:
				$problemModel->setProblem($espaceId, $id, 0);
				break;
		}
	}
}
;
