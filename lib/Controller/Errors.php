<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Robert Forristall <robert.s.forristall@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\NistCsfTool\Controller;

use Closure;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;

use OCA\NistCsfTool\Service\AppNotFound;

trait Errors {
	protected function handleNotFound(Closure $callback): DataResponse {
		try {
			return new DataResponse($callback());
		} catch (AppNotFound $e) {
			$message = ['message' => $e->getMessage()];
			return new DataResponse($message, Http::STATUS_NOT_FOUND);
		}
	}
}
