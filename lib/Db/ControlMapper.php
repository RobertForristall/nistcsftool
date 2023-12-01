<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Robert Forristall <robert.s.forristall@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\NistCsfTool\Db;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\Entity;
use OCP\AppFramework\Db\QBMapper;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IDBConnection;

/**
 * @template-extends QBMapper<Note>
 */
class ControlMapper extends QBMapper {
	public function __construct(IDBConnection $db) {
		parent::__construct($db, 'ControlCompliance', Control::class);
	}

	/**
	 * @throws \OCP\AppFramework\Db\MultipleObjectsReturnedException
	 * @throws DoesNotExistException
	 */
	public function find(string $control_id, int $app_id): Control {
		/* @var $qb IQueryBuilder */
		$qb = $this->db->getQueryBuilder();
		$qb->select('*')
			->from('ControlCompliance')
			->where($qb->expr()->eq('control_id', $qb->createNamedParameter($control_id, IQueryBuilder::PARAM_STR)))
			->andWhere($qb->expr()->eq('app_id', $qb->createNamedParameter($app_id, IQueryBuilder::PARAM_INT)));
		return $this->findEntity($qb);
	}

	/**
	 * @param string $app_id
	 * @return array
	 */
	public function findAll(int $app_id): array {
		/* @var $qb IQueryBuilder */
		$qb = $this->db->getQueryBuilder();
		$qb->select('*')
			->from('ControlCompliance')
			->where($qb->expr()->eq('app_id', $qb->createNamedParameter($app_id, IQueryBuilder::PARAM_INT)));
		return $this->findEntities($qb);
	}
}
