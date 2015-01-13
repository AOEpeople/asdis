<?php

/**
 * Scrapes the "href" attribute from "<link>" tags whose rel attribute is "apple-touch-icon-precomposed".
 *
 * @package Tx_Asdis
 * @subpackage Content_Scraper_Html
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Content_Scraper_Html_AppleTouchIcon extends Tx_Asdis_Content_Scraper_Html_AbstractHtmlScraper implements Tx_Asdis_Content_Scraper_ScraperInterface {

	/**
	 * @param $content
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function scrape($content) {
		return $this->getAssets('link', 'href', $content, array('rel' => 'apple-touch-icon-precomposed'));
	}
}