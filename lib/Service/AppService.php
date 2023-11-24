<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Robert Forristall <robert.s.forristall@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\NistCsfTool\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\NistCsfTool\Db\App;
use OCA\NistCsfTool\Db\AppMapper;

class AppService {
	private AppMapper $mapper;

	public function __construct(AppMapper $mapper) {
		$this->mapper = $mapper;
	}

	/**
	 * @return list<App>
	 */
	public function findAll(string $userId): array {
		return $this->mapper->findAll($userId);
	}

	/**
	 * @return never
	 */
	private function handleException(Exception $e) {
		if ($e instanceof DoesNotExistException ||
			$e instanceof MultipleObjectsReturnedException) {
			throw new AppNotFound($e->getMessage());
		} else {
			throw $e;
		}
	}

	public function find(int $id, string $userId): App {
		try {
			return $this->mapper->find($id, $userId);

			// in order to be able to plug in different storage backends like files
		// for instance it is a good idea to turn storage related exceptions
		// into service related exceptions so controllers and service users
		// have to deal with only one type of exception
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function create(string $name, string $type, string $userId): App {
		$App = new App();
		$App->setName($name);
		$App->setType($type);
		$App->setUserId($userId);
		return $this->mapper->insert($App);
	}
}
