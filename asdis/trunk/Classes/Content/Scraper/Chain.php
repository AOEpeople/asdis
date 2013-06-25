<?php

/**
 * Scraper which chains other scrapers.
 *
 * @package Tx_Asdis
 * @subpackage Content_Scraper
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Content_Scraper_Chain extends ArrayIterator implements Tx_Asdis_Content_Scraper_ScraperInterface {

	/**
	 * Needs to be called due to an extbase bug.
	 * Hides optional parameters of parent constructor.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * @param Tx_Asdis_Content_Scraper_ScraperInterface $scraper
	 */
	public function append(Tx_Asdis_Content_Scraper_ScraperInterface $scraper) {
		parent::append($scraper);
	}

	/**
	 * @param $content
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function scrape($content) {
		$assetCollection = new Tx_Asdis_Domain_Model_Asset_Collection();
		foreach($this as $scraper) {
			/** @var Tx_Asdis_Content_Scraper_ScraperInterface $scraper */
			$assetCollection->merge($scraper->scrape($content));
		}
		return $assetCollection;
	}
}