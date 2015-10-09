<?php

/**
 * Normalizes Uris.
 *
 * @package Tx_Asdis
 * @subpackage System_Uri
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Uri_Normalizer {

	/**
	 * Makes a path relative to the webroot.
	 *
	 * @param string $path                The path.
	 * @return string
	 */
	public function normalizePath($path) {
		// Fix for wildcard protocol URLs, as parse_url (until PHP 5.4.7) requires the protocol to be set
		// @see http://www.php.net/manual/en/function.parse-url.php
		if ('//' === substr($path, 0, 2)) {
			$path = 'http:' . $path;
		}

		$pathInfos = parse_url($path);

		if (isset($pathInfos['path'])) {
			$path = $pathInfos['path'];
			if (isset($pathInfos['query'])) {
				$path .= '?' . $pathInfos['query'];
			}
		}

		if (strpos($path, '/') === 0) {
			$path = substr($path, 1);
		}
		return $path;
	}
}