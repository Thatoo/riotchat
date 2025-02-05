<?php

declare(strict_types=1);
/**
 * @copyright Copyright (c) 2020 Gary Kim <gary@garykim.dev>
 *
 * @author Gary Kim <gary@garykim.dev>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\RiotChat\Controller;

use OCA\RiotChat\AppInfo\Application;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IConfig;
use OCP\IRequest;

class SettingsController extends Controller {

	/** @var IConfig */
	private $config;

	public function __construct($appName, IRequest $request, IConfig $config) {
		parent::__construct($appName, $request);

		$this->config = $config;
	}

	/**
	 * @param $key
	 * @return JSONResponse
	 */
	public function setSetting(string $key, string $value): JSONResponse {
		$labSettingNames = [];
		foreach (Application::AvailableLabs() as $k) {
			$labSettingNames[] = 'lab_' . $k;
		}
		if (!array_key_exists($key, Application::AvailableSettings) && !in_array($key, $labSettingNames)) {
			return new JSONResponse([
				'message' => 'parameter does not exist',
			], Http::STATUS_UNPROCESSABLE_ENTITY);
		}

		$this->config->setAppValue(Application::APP_ID, $key, $value);

		return new JSONResponse([
			'key' => $key,
			'value' => $value,
		]);
	}
}
