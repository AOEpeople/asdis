<?php

/**
 * Scraper chain factory.
 *
 * @package Tx_Asdis
 * @subpackage Content_Scraper
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Content_Scraper_ChainFactory {

	/**
	 * @var string
	 */
	const DECLARATION_KEY_KEY = 'key';

	/**
	 * @var string
	 */
	const DECLARATION_KEY_CLASS = 'class';

	/**
	 * @var string
	 */
	const DECLARATION_KEY_FILE = 'file';

	/**
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	private $objectManager;

	/**
	 * @var Tx_Asdis_System_Configuration_Provider
	 */
	private $configurationProvider;

	/**
	 * @param Tx_Extbase_Object_ObjectManager $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManager $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * @param Tx_Asdis_System_Configuration_Provider $configurationProvider
	 */
	public function injectConfigurationProvider(Tx_Asdis_System_Configuration_Provider $configurationProvider) {
		$this->configurationProvider = $configurationProvider;
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
	 * @throws Tx_Asdis_Content_Scraper_Exception_InvalidScraperDefinition
	 * @throws Tx_Asdis_Content_Scraper_Exception_ScraperNotExists
	 */
	private function buildScraper($scraperKey) {
		foreach($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'] as $scraperDeclaration) {
			if($scraperKey !== $scraperDeclaration[self::DECLARATION_KEY_KEY]) {
				continue;
			}
			if(FALSE === class_exists($scraperDeclaration[self::DECLARATION_KEY_CLASS])) {
				require_once($scraperDeclaration[self::DECLARATION_KEY_FILE]);
			}
			$scraper = $this->objectManager->create($scraperDeclaration[self::DECLARATION_KEY_CLASS]);
			if(FALSE === $scraper instanceof Tx_Asdis_Content_Scraper_ScraperInterface) {
				throw new Tx_Asdis_Content_Scraper_Exception_InvalidScraperDefinition(
					'Scraper "'.$scraperDeclaration[self::DECLARATION_KEY_CLASS].'" does not implement scraper interface.'
				);
			}
			return $scraper;
		}
		throw new Tx_Asdis_Content_Scraper_Exception_ScraperNotExists($scraperKey);
	}
}