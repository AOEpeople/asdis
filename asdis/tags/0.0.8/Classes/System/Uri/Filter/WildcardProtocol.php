<?php

/**
 * Filters paths that start with "//".
 *
 * @package Tx_Asdis
 * @subpackage System_Uri_Filter
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Uri_Filter_WildcardProtocol implements Tx_Asdis_System_Uri_Filter_FilterInterface {

	/**
	 * @param array $paths Array of paths.
	 * @return array Valid paths.
	 */
	public function filter(array $paths) {
		$filteredPaths = array();
		foreach ($paths as $path) {
			if (strpos($path, '//') === 0) {
				continue;
			}
			$filteredPaths[] = $path;
		}
		return $filteredPaths;
	}
}