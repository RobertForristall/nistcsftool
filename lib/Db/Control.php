<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Robert Forristall <robert.s.forristall@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\NistCsfTool\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

/**
 * @method getId(): int
 * @method getControlId(): string
 * @method setControlId(string $controlId): void
 * @method getAppId(): int
 * @method setAppId(int $appId): void
 * @method getComplianceValue(): int
 * @method setComplianceValue(int $complianceValue): void
 * @method getComment(): string
 * @method setComment(string $comment): void
 */
class Control extends Entity implements JsonSerializable {
	protected string $controlId = '';
	protected int $appId = -1;
	protected int $complianceValue = 4;
	protected ?string $comment = '';

	public function jsonSerialize(): array {
		return [
			'id' => $this->id,
			'control_id' => $this->controlId,
			'app_id' => $this->appId,
            'compliance_value' => $this->complianceValue,
			'comment' => $this->comment
		];
	}
}