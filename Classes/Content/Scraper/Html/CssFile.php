<?php

class Tx_Asdis_Content_Scraper_Html_CssFile extends Tx_Asdis_Content_Scraper_Html_AbstractHtmlScraper implements Tx_Asdis_Content_Scraper_ScraperInterface {

	/**
	 * @param $content
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function scrape($content) {
		return
			$this->getAssets('link', 'href', $content, array('rel' => 'stylesheet'))
				->merge($this->getAssets('link', 'href', $content, array('type' => 'text/css')));
	}
}