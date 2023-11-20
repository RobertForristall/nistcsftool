<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Robert Forristall <robert.s.forristall@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\NistCsfTool\AppInfo;

use OCP\AppFramework\App;

class Application extends App {
	public const APP_ID = 'nistcsftool';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}
}
