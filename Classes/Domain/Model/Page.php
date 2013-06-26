<?php

/**
 * Represents a page in the TYPO3 page tree.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Model
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Domain_Model_Page {

	/**
	 * @var Tx_Asdis_Domain_Model_Asset_Collection
	 */
	private $assets;

	/**
	 * @var tslib_fe
	 */
	private $pageObject;

	/**
	 * @var Tx_Asdis_Content_Scraper_ChainFactory
	 */
	private $scraperChainFactory;

	/**
	 * @var Tx_Asdis_Domain_Model_DistributionAlgorithm_DistributionAlgorithmInterface
	 */
	private $distributionAlgorithm;

	/**
	 * @var Tx_Asdis_Domain_Repository_ServerRepository
	 */
	private $serverRepository;

	/**
	 * @var Tx_Asdis_System_Configuration_Provider
	 */
	private $configurationProvider;

	/**
	 * @param Tx_Asdis_Content_Scraper_ChainFactory $scraperChainFactory
	 */
	public function injectScraperChainFactory(Tx_Asdis_Content_Scraper_ChainFactory $scraperChainFactory) {
		$this->scraperChainFactory = $scraperChainFactory;
	}

	/**
	 * @param Tx_Asdis_Domain_Model_DistributionAlgorithm_DistributionAlgorithmInterface $distributionAlgorithm
	 */
	public function injectDistributionAlgorithm(Tx_Asdis_Domain_Model_DistributionAlgorithm_DistributionAlgorithmInterface $distributionAlgorithm) {
		$this->distributionAlgorithm = $distributionAlgorithm;
	}

	/**
	 * @param Tx_Asdis_Domain_Repository_ServerRepository $serverRepository
	 */
	public function injectServerRepository(Tx_Asdis_Domain_Repository_ServerRepository $serverRepository) {
		$this->serverRepository = $serverRepository;
	}

	/**
	 * @param Tx_Asdis_System_Configuration_Provider $configurationProvider
	 */
	public function injectConfigurationProvider(Tx_Asdis_System_Configuration_Provider $configurationProvider) {
		$this->configurationProvider = $configurationProvider;
	}

	/**
	 * Scrapes the assets of the page. There is no replacement taking place. You have to call "replaceAssets" to replace
	 * the paths after calling "scrapeAssets".
	 *
	 * @return void
	 */
	public function scrapeAssets() {
		if(FALSE === $this->configurationProvider->isReplacementEnabled()) {
			return;
		}
		$this->setAssets($this->scraperChainFactory->buildChain()->scrape($this->pageObject->content));
	}

	/**
	 * Replaces the assets of the page.
	 * To force any replacement, you have to call "scrapeAssets" before.
	 *
	 * @return void
	 */
	public function replaceAssets() {
		if(FALSE === $this->configurationProvider->isReplacementEnabled()) {
			return;
		}
		$this->distributionAlgorithm->distribute($this->getAssets(), $this->serverRepository->findAllByPage($this));
		$replacement = $this->getAssets()->getReplacementMap();
		$this->pageObject->content = preg_replace(
			$replacement->getSources(),
			$replacement->getTargets(),
			$this->pageObject->content
		);
	}

	/**
	 * @param Tx_Asdis_Domain_Model_Asset_Collection $assets
	 */
	public function setAssets(Tx_Asdis_Domain_Model_Asset_Collection $assets) {
		$this->assets = $assets;
	}

	/**
	 * @param tslib_fe $pageObject
	 */
	public function setPageObject(tslib_fe $pageObject) {
		$this->pageObject = $pageObject;
	}

	/**
	 * @return tslib_fe
	 */
	public function getPageObject() {
		return $this->pageObject;
	}

	/**
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function getAssets() {
		return $this->assets;
	}
}