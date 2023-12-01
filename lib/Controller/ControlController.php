<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Robert Forristall <robert.s.forristall@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\NistCsfTool\Controller;

use OCA\NistCsfTool\AppInfo\Application;
use OCA\NistCsfTool\Service\ControlService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class ControlController extends Controller {
	private ControlService $service;
	private ?string $userId;

	use Errors;

	public function __construct(IRequest $request,
                                ControlService $service,
								?string $userId) {
		parent::__construct(Application::APP_ID, $request);
		$this->service = $service;
		$this->userId = $userId;
	}

	/**
	 * @NoAdminRequired
	 */
	public function index(string $app_id): DataResponse {
		return new DataResponse($this->service->findAll(intval($app_id)));
	}

	/**
	 * @NoAdminRequired
	 */
	public function show(string $control_id, int $app_id): DataResponse {
		return $this->handleNotFound(function () use ($control_id, $app_id) {
			return $this->service->find($control_id, $app_id);
		});
	}

	/**
	 * @NoAdminRequired
	 */
	public function create(string $control_id, int $app_id, int $compliance_value): DataResponse {
		return new DataResponse($this->service->create($control_id, $app_id, $compliance_value));
        // return new DataResponse("Test Response");
	}
}
