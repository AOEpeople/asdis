<?php

/**
 * Scrapes assets from JavaScript code used by the SwfObject library.
 *
 * @package Tx_Asdis
 * @subpackage Content_Scraper_Html
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Content_Scraper_Html_SwfObject implements Tx_Asdis_Content_Scraper_ScraperInterface {

	/**
	 * @var Tx_Asdis_Domain_Model_Asset_Factory
	 */
	private $assetFactory;

	/**
	 * @param Tx_Asdis_Domain_Model_Asset_Factory $assetFactory
	 */
	public function injectAssetFactory(Tx_Asdis_Domain_Model_Asset_Factory $assetFactory) {
		$this->assetFactory = $assetFactory;
	}

	/**
	 * @param $content
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function scrape($content) {
		return $this->assetFactory->createAssetsFromPaths($this->getSwfObjectPaths($content));
	}

	/**
	 * Returns a list of file paths parsed from calls to the swfObject JavaScript library.
	 *
	 * @param string $content
	 * @return array
	 */
	private function getSwfObjectPaths($content) {

		$paths   = array();
		$matches = array();
		$count   = preg_match_all(
			'~swfObject\.embedSWF\(\s?[\'"](.*?)[\'"]~is',
			$content,
			$matches,
			PREG_PATTERN_ORDER
		);

		if (is_array($matches) && sizeof($matches) > 1 && is_array($matches[1])) {
			$paths = $matches[1];
		}
	}
}