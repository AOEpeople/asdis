<?php

/**
 * Abstract scraper which provides general functionality to scrape paths from HTML tag attributes.
 *
 * @package Tx_Asdis
 * @subpackage Content_Scraper_Html
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
abstract class Tx_Asdis_Content_Scraper_Html_AbstractHtmlScraper {

	/**
	 * @var Tx_Asdis_Content_Scraper_Extractor_XmlTagAttribute
	 */
	private $xmlTagAttributeExtractor;

	/**
	 * @var Tx_Asdis_Domain_Model_Asset_Factory
	 */
	private $assetFactory;

	/**
	 * @param Tx_Asdis_Content_Scraper_Extractor_XmlTagAttribute $xmlTagAttributeExtractor
	 */
	public function injectXmlTagAttributeExtractor(Tx_Asdis_Content_Scraper_Extractor_XmlTagAttribute $xmlTagAttributeExtractor) {
		$this->xmlTagAttributeExtractor = $xmlTagAttributeExtractor;
	}

	/**
	 * @param Tx_Asdis_Domain_Model_Asset_Factory $assetFactory
	 */
	public function injectAssetFactory(Tx_Asdis_Domain_Model_Asset_Factory $assetFactory) {
		$this->assetFactory = $assetFactory;
	}

	/**
	 * @param string $tagName
	 * @param string $attributeName
	 * @param string $content
	 * @param array $requiredOtherAttributes
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	protected function getAssets($tagName, $attributeName, $content, array $requiredOtherAttributes = array()) {
		return $this->assetFactory->createAssetsFromPaths(
			$this->xmlTagAttributeExtractor->getAttributeFromTag(
				$tagName, $attributeName, $content, $requiredOtherAttributes
			)
		);
	}
}