<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Robert Forristall <robert.s.forristall@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\NistCsfTool\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

/**
 * @method getId(): int
 * @method getName(): string
 * @method setName(string $name): void
 * @method getType(): string
 * @method setType(string $type): void
 * @method getUserId(): string
 * @method setUserId(string $userId): void
 */
class App extends Entity implements JsonSerializable {
	protected string $name = '';
	protected string $type = '';
	protected string $userId = '';

	public function jsonSerialize(): array {
		return [
			'id' => $this->id,
			'name' => $this->name,
			'type' => $this->type
		];
	}
}
