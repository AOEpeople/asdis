<?php

/**
 * Scraper interface.
 *
 * @package Tx_Asdis
 * @subpackage Content_Scraper
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
interface Tx_Asdis_Content_Scraper_ScraperInterface {

	/**
	 * @param string $content
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function scrape($content);
}