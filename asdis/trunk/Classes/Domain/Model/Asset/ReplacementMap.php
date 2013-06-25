<?php

/**
 * File path replacement map for asset paths.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Model_Asset
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Domain_Model_Asset_ReplacementMap {

	/**
	 * @var array
	 */
	private $sourcePaths = array();

	/**
	 * @var array
	 */
	private $targetPaths = array();

	/**
	 * @param string $sourcePath
	 * @param string $targetPath
	 */
	public function addMapping($sourcePath, $targetPath) {
		$this->sourcePaths[] = $sourcePath;
		$this->targetPaths[] = $targetPath;
	}

	/**
	 * @return array
	 */
	public function getSourcePaths() {
		return $this->sourcePaths;
	}

	/**
	 * @return array
	 */
	public function getTargetPaths() {
		return $this->targetPaths;
	}
}