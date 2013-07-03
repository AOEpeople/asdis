<?php

/**
 * Scrapes paths from "url()" in CSS.
 *
 * @package Tx_Asdis
 * @subpackage Content_Scraper_Css
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Content_Scraper_Css_Url implements Tx_Asdis_Content_Scraper_ScraperInterface {

	/**
	 * @var Tx_Asdis_Domain_Model_Asset_Factory
	 */
	private $assetFactory;

	/**
	 * @param Tx_Asdis_Domain_Model_Asset_Factory $assetFactory
	 */
	public function injectAssetFactory(Tx_Asdis_Domain_Model_Asset_Factory $assetFactory) {
		$this->assetFactory = $assetFactory;
	}

	/**
	 * @param $content
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function scrape($content) {
		return $this->assetFactory->createAssetsFromPaths($this->extractUrlPaths($content));
	}

	/**
	 * Extracts paths to resources in CSS code.
	 * This means file references which are included in "url(...)".
	 *
	 * @param string $cssContent
	 * @return array
	 */
	private function extractUrlPaths($cssContent) {

		$paths   = array();
		$matches = array();

		preg_match_all(
			'~url\(\s*[\'"]?(/?(\.\./)?.*?)[\'"]?;?\s*\)~is',
			$cssContent,
			$matches,
			PREG_PATTERN_ORDER
		);

		if (FALSE === (is_array($matches) && sizeof($matches) > 1 && is_array($matches[1]))) {
			return $paths;
		}

		foreach ($matches[1] as $path) {
			if (strpos($path, ",") !== FALSE) {
				continue;
			}
			$paths[] = $path;
		}

		return $paths;
	}
}