<?php

/**
 * Is thrown when a requested scraper does not exist.
 *
 * @package Tx_Asdis
 * @subpackage Content_Scraper_Exception
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Content_Scraper_Exception_ScraperNotExists extends Exception {

	/**
	 * @param string $filterKey
	 */
	public function __construct($filterKey) {
		parent::__construct('Scraper with the key ' . $filterKey . ' does not exist.', 1371818682112);
	}
}