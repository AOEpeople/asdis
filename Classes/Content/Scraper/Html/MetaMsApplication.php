<?php

/**
 * Scrapes assets from "<meta property="og:image">" tags.
 *
 * @package Tx_Asdis
 * @subpackage Content_Scraper_Html
 * @author Kevin Schu <kevin.schu@aoe.com>
 */
class Tx_Asdis_Content_Scraper_Html_MetaMsApplication extends Tx_Asdis_Content_Scraper_Html_AbstractHtmlScraper implements Tx_Asdis_Content_Scraper_ScraperInterface {

	/**
	 * @param $content
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function scrape($content) {
		return $this->getAssets('meta', 'content', $content, array('name' => 'msapplication-TileImage'))
            ->merge($this->getAssets('meta', 'content', $content, array('name' => 'msapplication-config')));
	}
}