<?php

class Tx_Asdis_Content_Scraper_Html_InputImage extends Tx_Asdis_Content_Scraper_Html_AbstractHtmlScraper implements Tx_Asdis_Content_Scraper_ScraperInterface {

	/**
	 * @param $content
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function scrape($content) {
		return $this->getAssets('input', 'src', $content, array('type' => 'image'));
	}
}