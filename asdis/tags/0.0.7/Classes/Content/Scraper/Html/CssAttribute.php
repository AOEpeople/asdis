<?php

/**
 * Scrapes assets from inline CSS.
 *
 * @package Tx_Asdis
 * @subpackage Content_Scraper_Html
 */
class Tx_Asdis_Content_Scraper_Html_CssAttribute implements Tx_Asdis_Content_Scraper_ScraperInterface {

	/**
	 * @var Tx_Asdis_Content_Scraper_Css_Url
	 */
	private $cssUrlScraper;

	/**
	 * @param Tx_Asdis_Content_Scraper_Css_Url $cssUrlScraper
	 */
	public function injectCssUrlScraper(Tx_Asdis_Content_Scraper_Css_Url $cssUrlScraper) {
		$this->cssUrlScraper = $cssUrlScraper;
	}

	/**
	 * @param $content
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function scrape($content) {
		return $this->cssUrlScraper->scrape(implode(PHP_EOL, $this->getStyleBlocksFromMarkup($content)));
	}

	/**
	 * Returns the inner content of all <style></style> blocks of the given markup as an array.
	 *
	 * @param string $content
	 * @return array
	 */
	private function getStyleBlocksFromMarkup($content) {
		$blocks = array();
		$matches = array();
		preg_match_all(
			'/style=.*(url\(.*\))/i',
			$content,
			$matches
		);
		if (is_array($matches) && sizeof($matches) > 1 && is_array($matches[1])) {
			$blocks = $matches[1];
		}
		return $blocks;
	}
}