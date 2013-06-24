<?php

/**
 * Collection which contains asset objects.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Model
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Domain_Model_Asset_Collection extends ArrayIterator {

	/**
	 * @var array
	 */
	private $elementHashes = array();

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
	 */
	public function merge(Tx_Asdis_Domain_Model_Asset_Collection $assetCollection) {
		foreach($assetCollection as $asset) {
			$this->append($asset);
		}
	}

	/**
	 * @return Tx_Asdis_Domain_Model_Asset_ReplacementMap
	 */
	public function getReplacementMap() {
		$map = new Tx_Asdis_Domain_Model_Asset_ReplacementMap();
		foreach($this as $asset) {
			/** @var Tx_Asdis_Domain_Model_Asset $asset */
			//$map->addMapping($asset->getOriginalPath(), $asset->getUri());
			$map->addMapping($asset->getPregQuotedOriginalPath(), $asset->getUri());
		}
		return $map;
	}
}