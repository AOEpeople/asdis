<?php

/**
 * Represents a page in the TYPO3 page tree.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Model
 * @author Timo Fuchs <timo.fuchs@aoe.com>
 */
class Tx_Asdis_Domain_Model_Page {

	/**
	 * @var Tx_Asdis_Domain_Model_Asset_Collection
	 */
	private $assets;

	/**
	 * @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
	 */
	private $pageObject;

	/**
	 * @var Tx_Asdis_Content_Scraper_ChainFactory
	 */
	private $scraperChainFactory;

	/**
	 * @var Tx_Asdis_Domain_Model_DistributionAlgorithm_Factory
	 */
	private $distributionAlgorithmFactory;

	/**
	 * @var Tx_Asdis_Domain_Repository_ServerRepository
	 */
	private $serverRepository;

	/**
	 * @var Tx_Asdis_System_Configuration_Provider
	 */
	private $configurationProvider;

	/**
	 * @var Tx_Asdis_Content_Replacement_Processor
	 */
	private $replacementProcessor;

	/**
	 * @param Tx_Asdis_Content_Scraper_ChainFactory $scraperChainFactory
	 */
	public function injectScraperChainFactory(Tx_Asdis_Content_Scraper_ChainFactory $scraperChainFactory) {
		$this->scraperChainFactory = $scraperChainFactory;
	}

	/**
	 * @param Tx_Asdis_Domain_Model_DistributionAlgorithm_Factory $distributionAlgorithmFactory
	 */
	public function injectDistributionAlgorithmFactory(Tx_Asdis_Domain_Model_DistributionAlgorithm_Factory $distributionAlgorithmFactory) {
		$this->distributionAlgorithmFactory = $distributionAlgorithmFactory;
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
	 * @param Tx_Asdis_Content_Replacement_Processor $replacementProcessor
	 */
	public function injectReplacementProcessor(Tx_Asdis_Content_Replacement_Processor $replacementProcessor) {
		$this->replacementProcessor = $replacementProcessor;
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
		$distributionAlgorithmKey = '';
		try {
			$distributionAlgorithmKey = $this->configurationProvider->getDistributionAlgorithmKey();
		} catch(Exception $e) {}
		$distributionAlgorithm = $this->distributionAlgorithmFactory->buildDistributionAlgorithmFromKey($distributionAlgorithmKey);
		$distributionAlgorithm->distribute($this->getAssets(), $this->serverRepository->findAllByPage($this));
		$this->pageObject->content = $this->replacementProcessor->replace(
			$this->assets->getReplacementMap(),
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
	 * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $pageObject
	 */
	public function setPageObject(\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $pageObject) {
		$this->pageObject = $pageObject;
	}

	/**
	 * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
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