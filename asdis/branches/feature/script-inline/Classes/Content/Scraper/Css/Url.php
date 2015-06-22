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
		$urls = $this->extractUrlPaths($content);
		return $this->assetFactory->createAssetsFromPaths($urls['paths'], $urls['masks']);
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
		$masks   = array();
		$matches = array();

		preg_match_all(
			'~url\(\s*([\'"]?)(/?(\.\./)?.*?)([\'"]?);?\s*\)~is',
			$cssContent,
			$matches,
			PREG_PATTERN_ORDER
		);

		if (FALSE === (is_array($matches) && sizeof($matches) > 1 && is_array($matches[2]))) {
			return array(
				'paths' => $paths,
				'masks' => $masks
			);
		}

		foreach ($matches[2] as $mkey => $path) {
			if (strpos($path, ",") !== FALSE) {
				continue;
			}
			$paths[] = $path;
			$masks[] = $matches[1][$mkey];
		}

		return array(
			'paths' => $paths,
			'masks' => $masks
		);
	}
}