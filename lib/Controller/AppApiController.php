<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Robert Forristall <robert.s.forristall@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\NistCsfTool\Controller;

use OCA\NistCsfTool\AppInfo\Application;
use OCA\NistCsfTool\Service\AppService;
use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class AppApiController extends ApiController {
	private AppService $service;
	private ?string $userId;

	use Errors;

	public function __construct(IRequest $request,
                                AppService $service,
								?string $userId) {
		parent::__construct(Application::APP_ID, $request);
		$this->service = $service;
		$this->userId = $userId;
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function index(): DataResponse {
		return new DataResponse($this->service->findAll($this->userId));
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function show(int $id): DataResponse {
		return $this->handleNotFound(function () use ($id) {
			return $this->service->find($id, $this->userId);
		});
	}

	/**
	 * @CORS
	 * @NoCSRFRequired
	 * @NoAdminRequired
	 */
	public function create(string $name, string $type): DataResponse {
		return new DataResponse($this->service->create($name, $type,
			$this->userId));
	}
}
