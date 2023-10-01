<?php

declare(strict_types=1);
/**
 * @copyright Copyright (c) 2019 Robin Appelman <robin@icewind.nl>
 * @copyright Copyright (c) 2020 Gary Kim <gary@garykim.dev>
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

namespace OCA\RiotChat;

use OC\AppFramework\Http;
use OCP\AppFramework\Http\ICallbackResponse;
use OCP\AppFramework\Http\IOutput;
use OCP\AppFramework\Http\Response;
use TypeError;

class FileResponse extends Response implements ICallbackResponse {
	private $data;
	private $name;

	public function __construct($data, int $length, int $lastModified, string $mimeType, string $name, int $statusCode = Http::STATUS_OK,
								array $headers = []) {
		$this->data = $data;
		$this->name = $name;
		$this->setStatus($statusCode);

		try {
			$this->setHeaders(array_merge($this->getHeaders(), $headers));
		} catch (TypeError $ex) {
			$this->setHeaders($headers);
		}

		$this->addHeader('Content-Length', $length);
		$this->addHeader('Content-Type', $mimeType);

		$lastModifiedDate = new \DateTime();
		$lastModifiedDate->setTimestamp($lastModified);
		$this->setLastModified($lastModifiedDate);
	}

	/**
	 * @param IOutput $output
	 * @since 11.0.0
	 */
	public function callback(IOutput $output) {
		if ($output->getHttpResponseCode() !== Http::STATUS_NOT_MODIFIED) {
			if (is_resource($this->data)) {
				fpassthru($this->data);
			} else {
				print $this->data;
			}
		}
	}

	public function setDownload() {
		$encodedName = rawurlencode(basename($this->name));
		$this->addHeader(
			'Content-Disposition',
			'attachment; filename*=UTF-8\'\'' . $encodedName . '; filepath="' . $encodedName . '"'
		);
	}
}
