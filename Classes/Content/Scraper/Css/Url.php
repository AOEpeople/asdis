<?php

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
	 * @todo cleanup
	 * @param string $cssContent
	 * @return array
	 */
	private function extractUrlPaths($cssContent) {

		$paths   = array();
		$matches = array();
		$count   = 0;

		$count = preg_match_all(
			'~url\(\s*[\'"]?(/?(\.\./)?.*?)[\'"]?;?\s*\)~is',
			$cssContent,
			$matches,
			PREG_PATTERN_ORDER
		);

		if (is_array($matches) && sizeof($matches) > 1 && is_array($matches[1])) {
			$paths = $matches[1];
		}

		// @todo remove that ugly workaround
		if (sizeof($paths) > 0) {
			$allPaths = $paths;
			$paths    = array();
			foreach ($allPaths as $path) {
				if (strpos($path, ",") === FALSE) {
					$paths[] = $path;
				}
			}
		}

		return $paths;
	}
}