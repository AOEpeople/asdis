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
		if(strpos($path, "/") === 0) {
			$path = substr($path, 1);
		}
		return $path;
	}
}