<?php

/**
 * Scrapes assets from all tags by using data-src attributes.
 *
 * @package Tx_Asdis
 * @subpackage Content_Scraper_Html
 * @author Kevin Schu <kevin.schu@aoe.com>
 */
class Tx_Asdis_Content_Scraper_Html_Css3Image extends Tx_Asdis_Content_Scraper_Html_AbstractHtmlScraper
    implements Tx_Asdis_Content_Scraper_ScraperInterface {

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
	 * @param string $content
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function scrape($content) {
        $paths = array();
        $matches = array();
        preg_match_all(
            '/data-src-[^=]*\s?=\s?[\'"](.*?)[\'"]/i',
            $content,
            $matches
        );
        if (is_array($matches) && sizeof($matches) > 1 && is_array($matches[1])) {
            $paths = $matches[1];
        }
        return $this->assetFactory->createAssetsFromPaths($paths);
	}
}