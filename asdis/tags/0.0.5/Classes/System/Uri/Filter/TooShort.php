<?php

/**
 * Filters paths which are too short.
 *
 * @package Tx_Asdis
 * @subpackage System_Uri_Filter
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Uri_Filter_TooShort implements Tx_Asdis_System_Uri_Filter_FilterInterface {

	/**
	 * @var integer
	 */
	const MIN_LENGTH = 5;

	/**
	 * @param array $paths Array of paths.
	 * @return array Valid paths.
	 */
	public function filter(array $paths) {
		$filteredPaths = array();
		foreach ($paths as $path) {
			if (strlen($path) < self::MIN_LENGTH) {
				continue;
			}
			$filteredPaths[] = $path;
		}
		return $filteredPaths;
	}
}