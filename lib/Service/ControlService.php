<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Robert Forristall <robert.s.forristall@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\NistCsfTool\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\NistCsfTool\Db\Control;
use OCA\NistCsfTool\Db\ControlMapper;

class ControlService {
	private ControlMapper $mapper;

	public function __construct(ControlMapper $mapper) {
		$this->mapper = $mapper;
	}

	/**
	 * @return list<Control>
	 */
	public function findAll(int $app_id): array {
		return $this->mapper->findAll($app_id);
	}

	/**
	 * @return never
	 */
	private function handleException(Exception $e) {
		if ($e instanceof DoesNotExistException ||
			$e instanceof MultipleObjectsReturnedException) {
			throw new ControlNotFound($e->getMessage());
		} else {
			throw $e;
		}
	}

	public function find(string $control_id, int $app_id): Control {
		try {
			return $this->mapper->find($control_id, $app_id);

			// in order to be able to plug in different storage backends like files
		// for instance it is a good idea to turn storage related exceptions
		// into service related exceptions so controllers and service users
		// have to deal with only one type of exception
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function create(string $control_id, int $app_id, int $compliance_value): Control {
        try {
            $Control = $this->mapper->find($control_id, $app_id);
            $Control->setControlId($control_id);
            $Control->setAppId($app_id);
            $Control->setComplianceValue($compliance_value);
            return $this->mapper->update($Control);
        } catch (DoesNotExistException $e) {
            $Control = new Control();
            $Control->setControlId($control_id);
            $Control->setAppId($app_id);
            $Control->setComplianceValue($compliance_value);
            return $this->mapper->insert($Control);
        }
	}
}
