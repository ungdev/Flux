<?php

namespace models;

class Coin extends Model
{
	protected $db;
	protected $conf;

	public function transferList($espaceId = null) {
		$where = '';
		$bind = [];
		if($espaceId > 0) {
			$where = 'AND `espace_id` = :espaceId';
			$bind = [
				':espaceId' => $espaceId
			];
		}

		$sth = $this->db->prepare(
			'SELECT `c`.`id`, `espace_id`,
				`transferredAt`, `transferredBy`,`u1`.`login` as `transferredBy_nom`,
				`countedAt`, `countedBy`,`u2`.`login` as `countedBy_nom`, `value`, `e`.`nom`
			FROM `coin_transfers` `c`
			LEFT JOIN `espace` `e`
				ON `e`.`id` = `espace_id`
			LEFT JOIN `utilisateur` `u1`
				ON `u1`.`id` = `transferredBy`
			LEFT JOIN `utilisateur` `u2`
				ON `u2`.`id` = `countedBy`
			WHERE deletedAt is null '
			.$where.'
			ORDER BY transferredAt DESC');
		$sth->execute($bind);
		return $sth;
	}

	public function transferSum($espaceId = null) {
		$where = '';
		$bind = [];
		if($espaceId > 0) {
			$where = 'AND `espace_id` = :espaceId';
			$bind = [
				':espaceId' => $espaceId
			];
		}

		$sth = $this->db->prepare(
			'SELECT SUM(`value`) as `sum`, SUM(IF(`value` < 0,`value`,0)) as `debit`, SUM(IF(`value` >= 0,`value`,0)) as `credit`
			FROM `coin_transfers`
			WHERE deletedAt is null
			'.$where);
		$sth->execute($bind);
		return $sth;
	}

	public function createMultipleTransfers($userId, $espaceIdArray) {
		$bind = [];

		$query = 'INSERT INTO `coin_transfers`(`espace_id`, `transferredAt`, `transferredBy`, `countedAt`, `countedBy`, `value`) VALUES ';
		$i = 0;
		foreach ($espaceIdArray as $key => $value) {
			if($i != 0) {
				$query .= ',';
			}
			$query .= '(:espace'.$i.',NOW(),:userId,null,null,null)';
			$bind[':espace'.$i] = $key;
			$bind[':userId'] = $userId;
			$i++;
		}
		$sth = $this->db->prepare($query);
		$sth->execute($bind);
		return $sth;
	}

	public function createCountedTransfers($userId, $espaceId, $value) {
		$sth = $this->db->prepare(
		'UPDATE `coin_transfers` SET `deletedAt`=NOW() WHERE id=:id');
		$sth->execute([
			':espaceId' => $espaceId,
			':userId' => $userId,
			':value' => $value
		]);
		return $sth;
	}

	public function updateTransfer($id, $value, $userId) {
		$sth = $this->db->prepare(
		'UPDATE `coin_transfers` SET `countedBy`=:userId, `countedAt`=NOW(), `value`=:value WHERE id=:id');
		$sth->execute([
			':id' => $id,
			':value' => $value,
			':userId' => $userId
		]);
		return $sth;
	}

	public function softRemoveTransfer($id) {
		$sth = $this->db->prepare(
		'UPDATE `coin_transfers` SET `deletedAt`=NOW() WHERE id=:id');
		$sth->execute([
			':id' => $id
		]);
		return $sth;
	}
}
