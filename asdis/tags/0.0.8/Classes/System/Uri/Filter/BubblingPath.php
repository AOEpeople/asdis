<?php

/**
 * Filters paths that contain "../".
 *
 * @package Tx_Asdis
 * @subpackage System_Uri_Filter
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Uri_Filter_BubblingPath implements Tx_Asdis_System_Uri_Filter_FilterInterface {

	/**
	 * @param array $paths Array of paths.
	 * @return array Valid paths.
	 */
	public function filter(array $paths) {
		$filteredPaths = array();
		foreach ($paths as $path) {
			if ($this->containsBubblingPath($path)) {
				continue;
			}
			$filteredPaths[] = $path;
		}
		return $filteredPaths;
	}

	/**
	 * @param string $path
	 * @return boolean
	 */
	private function containsBubblingPath($path) {
		return (FALSE !== strpos($path, '../'));
	}
}