<?php

/**
 * Scrapes the "data-quality-high" attribute from "<img>" tags.
 * This is used by the jQuery Retina JavaScript plugin.
 *
 * @package Tx_Asdis
 * @subpackage Content_Scraper_Html
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Content_Scraper_Html_JQueryRetina extends Tx_Asdis_Content_Scraper_Html_AbstractHtmlScraper implements Tx_Asdis_Content_Scraper_ScraperInterface {

	/**
	 * @param $content
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function scrape($content) {
		return $this->getAssets('img', 'data-quality-high', $content);
	}
}