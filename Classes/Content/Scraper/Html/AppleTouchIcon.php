<?php

/**
 * Scrapes the "href" attribute from "<link>" tags whose rel attribute is "apple-touch-icon" or "apple-touch-icon-precomposed".
 *
 * @package Tx_Asdis
 * @subpackage Content_Scraper_Html
 * @author Kevin Schu <kevin.schu@aoe.com>
 */
class Tx_Asdis_Content_Scraper_Html_AppleTouchIcon extends Tx_Asdis_Content_Scraper_Html_AbstractHtmlScraper implements Tx_Asdis_Content_Scraper_ScraperInterface {

	/**
	 * @param string $content
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function scrape($content) {
		return $this->getAssets('link', 'href', $content, array('rel' => 'apple-touch-icon'))
            ->merge($this->getAssets('link', 'href', $content, array('rel' => 'apple-touch-icon-precomposed')));
	}
}