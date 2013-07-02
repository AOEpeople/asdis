<?php

/**
 * Scraper chain factory.
 *
 * @package Tx_Asdis
 * @subpackage Content_Scraper
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Content_Scraper_ChainFactory extends Tx_Asdis_System_Factory_AbstractDeclarationBasedFactory {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->setDeclarations($this->getScraperDecalarations());
		$this->setClassImplements(array('Tx_Asdis_Content_Scraper_ScraperInterface'));
	}

	/**
	 * @return Tx_Asdis_Content_Scraper_Chain
	 */
	public function buildChain() {
		/** @var Tx_Asdis_Content_Scraper_Chain $chain */
		$chain = $this->objectManager->create('Tx_Asdis_Content_Scraper_Chain');
		foreach($this->configurationProvider->getScraperKeys() as $scraperKey) {
			$chain->append($this->buildScraper($scraperKey));
		}
		return $chain;
	}

	/**
	 * @param string $scraperKey
	 * @return Tx_Asdis_Content_Scraper_ScraperInterface
	 */
	private function buildScraper($scraperKey) {
		return $this->buildObjectFromKey($scraperKey);
	}

	/**
	 * @return array
	 */
	protected function getScraperDecalarations() {
		if(FALSE === isset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'])) {
			return array();
		}
		return $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'];
	}
}