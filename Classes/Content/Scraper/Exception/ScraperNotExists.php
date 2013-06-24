<?php

class Tx_Asdis_Content_Scraper_Exception_ScraperNotExists extends Exception {

	/**
	 * @param string $scraperKey
	 */
	public function __construct($scraperKey) {
		parent::__construct('Scraper with the key ' . $scraperKey . ' does not exist.', 1371818682112);
	}
}