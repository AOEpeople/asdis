<?php

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