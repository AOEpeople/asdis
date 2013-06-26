<?php

/**
 * A content replacement map.
 *
 * @package Tx_Asdis
 * @subpackage Content_Replacement
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Content_Replacement_Map {

	/**
	 * @var array
	 */
	private $sources = array();

	/**
	 * @var array
	 */
	private $targets = array();

	/**
	 * @param string $source
	 * @param string $target
	 */
	public function addMapping($source, $target) {
		$this->sources[] = $source;
		$this->targets[] = $target;
	}

	/**
	 * @return array
	 */
	public function getSources() {
		return $this->sources;
	}

	/**
	 * @return array
	 */
	public function getTargets() {
		return $this->targets;
	}
}