<?php

/**
 * Collection which contains asset objects.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Model_Asset
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Domain_Model_Asset_Collection extends ArrayIterator {

	/**
	 * @var array
	 */
	private $elementHashes = array();

	/**
	 * Needs to be called due to an extbase bug.
	 * Hides optional parameters of parent constructor.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * @param Tx_Asdis_Domain_Model_Asset $asset
	 */
	public function append(Tx_Asdis_Domain_Model_Asset $asset) {
		$elementHash = $asset->getHash();
		if(in_array($elementHash, $this->elementHashes)) {
			return;
		}
		$this->elementHashes[] = $elementHash;
		parent::append($asset);
	}

	/**
	 * @param Tx_Asdis_Domain_Model_Asset_Collection $assetCollection
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function merge(Tx_Asdis_Domain_Model_Asset_Collection $assetCollection) {
		foreach($assetCollection as $asset) {
			$this->append($asset);
		}
		return $this;
	}

	/**
	 * @return Tx_Asdis_Content_Replacement_Map
	 */
	public function getReplacementMap() {
		$map = new Tx_Asdis_Content_Replacement_Map();
		foreach($this as $asset) {
			/** @var Tx_Asdis_Domain_Model_Asset $asset */
			$map->addMapping(
				$asset->getMaskedPregQuotedOriginalPath(),
				$asset->getMask() . $asset->getUri() . $asset->getMask()
			);
		}
		return $map;
	}
}