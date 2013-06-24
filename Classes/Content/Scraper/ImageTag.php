<?php

class Tx_Asdis_Content_Scraper_ImageTag implements Tx_Asdis_Content_Scraper_ScraperInterface {

	/**
	 * @var Tx_Asdis_Content_Scraper_Service_MarkupExtractor
	 */
	private $markupExtractor;

	/**
	 * @var Tx_Asdis_Domain_Model_Asset_Factory
	 */
	private $assetFactory;

	/**
	 * @param Tx_Asdis_Content_Scraper_Service_MarkupExtractor $markupExtractor
	 */
	public function injectMarkupExtractor(Tx_Asdis_Content_Scraper_Service_MarkupExtractor $markupExtractor) {
		$this->markupExtractor = $markupExtractor;
	}

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
		return $this->assetFactory->createAssetsFromPaths(
			$this->markupExtractor->getAttributeFromTag('img', 'src', $content)
		);
	}
}