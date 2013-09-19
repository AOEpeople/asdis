<?php

/**
 * Filters paths that start with "data:".
 *
 * @package Tx_Asdis
 * @subpackage System_Uri_Filter
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Uri_Filter_ContainsInlineData implements Tx_Asdis_System_Uri_Filter_FilterInterface {

	/**
	 * @param array $paths Array of paths.
	 * @return array Valid paths.
	 */
	public function filter(array $paths) {
		$filteredPaths = array();
		foreach ($paths as $path) {
			if (0 === strpos($path, 'data:')) {
				continue;
			}
			$filteredPaths[] = $path;
		}
		return $filteredPaths;
	}
}