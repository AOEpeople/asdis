<?php

/**
 * Abstract hook class.
 *
 * @package Tx_Asdis
 * @subpackage Typo3_Hook
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
abstract class Tx_Asdis_Typo3_Hook_AbstractHook {

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * @var Tx_Asdis_System_Log_Logger
	 */
	private $logger;

	/**
	 * @var Tx_Asdis_Domain_Model_Page
	 */
	private $page;

	/**
	 * @var Tx_Asdis_System_Configuration_Provider
	 */
	private $configurationProvider;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$this->configurationProvider = $this->objectManager->get('Tx_Asdis_System_Configuration_Provider');
		$this->logger = $this->objectManager->get('Tx_Asdis_System_Log_Logger');
	}

	/**
	 * @return Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected function getObjectManager() {
		return $this->objectManager;
	}

	/**
	 * @return Tx_Asdis_System_Configuration_Provider
	 */
	protected function getConfigurationProvider() {
		return $this->configurationProvider;
	}

	/**
	 * @return Tx_Asdis_System_Log_Logger
	 */
	protected function getLogger() {
		return $this->logger;
	}

	/**
	 * @return void
	 */
	protected function scrapeAssets() {
		$this->page->scrapeAssets();
	}

	/**
	 * @param tslib_fe $pObj
	 */
	protected function replaceAssets() {
		$this->page->replaceAssets();
	}

	/**
	 * Scrapes and replaces the assets of the current page.
	 *
	 * @return void
	 */
	protected function scrapeAndReplace() {
		$this->scrapeAssets();
		$this->replaceAssets();
	}

	/**
	 * @param tslib_fe $pObj
	 */
	protected function setPageObject(tslib_fe $pObj) {
		/** @var Tx_Asdis_Domain_Model_Page $page */
		$page = $this->getObjectManager()->get('Tx_Asdis_Domain_Model_Page');
		$page->setAssets($this->getObjectManager()->get('Tx_Asdis_Domain_Model_Asset_Collection'));
		$page->setPageObject($pObj);
		$this->page = $page;
	}
}