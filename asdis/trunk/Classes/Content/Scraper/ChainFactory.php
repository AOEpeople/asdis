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
	 * @return Tx_Asdis_Content_Scraper_Chain
	 */
	public function buildChain() {
		$this->initialize();
		/** @var Tx_Asdis_Content_Scraper_Chain $chain */
		$chain = $this->objectManager->create('Tx_Asdis_Content_Scraper_Chain');
		foreach($this->configurationProvider->getScraperKeys() as $scraperKey) {
			$chain->append($this->buildScraper($scraperKey));
		}
		return $chain;
	}

	/**
	 * @return void
	 */
	private function initialize() {
		$this->setDeclarations($this->getScraperDeclarations());
		$this->setClassImplements(array('Tx_Asdis_Content_Scraper_ScraperInterface'));
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
	protected function getScraperDeclarations() {
		if(FALSE === isset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'])) {
			return array();
		}
		return $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'];
	}
}