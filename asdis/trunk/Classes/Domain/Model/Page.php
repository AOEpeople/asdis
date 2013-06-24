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
	 * @var string
	 */
	private $serializedAssets;

	/**
	 * @var tslib_fe
	 */
	private $pageObject;

	/**
	 * @var Tx_Asdis_System_Configuration_TypoScriptConfiguration
	 */
	private $configuration;

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
	 *
	 */
	public function scrapeAssets() {
		$this->setAssets($this->scraperChainFactory->buildChain()->scrape($this->getContent()));
	}

	public function replaceAssets() {
		$this->injectDistributionAlgorithm(new Tx_Asdis_Domain_Model_DistributionAlgorithm_RoundRobin());
		$this->distributionAlgorithm->distribute($this->getAssets(), $this->serverRepository->findAllByPage($this));
		$replacement = $this->getAssets()->getReplacementMap();
		//var_dump($replacement); die('h');
		$this->setContent(preg_replace($replacement->getSourcePaths(), $replacement->getTargetPaths(), $this->getContent()));
	}

	/**
	 * @param Tx_Asdis_Domain_Model_Asset_Collection $assets
	 */
	public function setAssets(Tx_Asdis_Domain_Model_Asset_Collection $assets) {
		$this->assets = $assets;
		$this->setSerializedAssets(serialize($assets));
	}

	/**
	 * @param tslib_fe $pageObject
	 */
	public function setPageObject(tslib_fe $pageObject) {
		$this->pageObject = $pageObject;
	}

	/**
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function getAssets() {
		if(FALSE === isset($this->assets)) {
			$this->assets = unserialize($this->serializedAssets);
		}
		return $this->assets;
	}

	/**
	 * @return integer
	 */
	public function getLanguageUid() {
		return $this->pageObject->sys_language_uid;
	}

	/**
	 * @return integer
	 */
	public function getUid() {
		return $this->pageObject->id;
	}

	/**
	 * @return string
	 */
	public function getContent() {
		return $this->pageObject->content;
	}

	/**
	 * @param string $content
	 */
	public function setContent($content) {
		$this->pageObject->content = $content;
	}

	/**
	 * @param string $serializedAssets
	 */
	public function setSerializedAssets($serializedAssets) {
		$this->serializedAssets = $serializedAssets;
	}
}