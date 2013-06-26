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
	 * Constructor.
	 */
	public function __construct() {
		$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$this->logger = $this->objectManager->get('Tx_Asdis_System_Log_Logger');
	}

	/**
	 * @return Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected function getObjectManager() {
		return $this->objectManager;
	}

	/**
	 * @return Tx_Asdis_System_Log_Logger
	 */
	protected function getLogger() {
		return $this->logger;
	}

	/**
	 *
	 */
	protected function scrapeAssets() {
		$this->getLogger()->log(__METHOD__, 'scrapeAssets');
		$this->page->scrapeAssets();
	}

	/**
	 * @param tslib_fe $pObj
	 */
	protected function replaceAssets() {
		$this->getLogger()->log(__METHOD__, 'replaceAssets');
		$this->page->replaceAssets();
	}

	/**
	 *
	 */
	protected function scrapeAndReplace() {
		$this->scrapeAssets();
		$this->replaceAssets();
	}

	/**
	 * @param tslib_fe $pObj
	 */
	protected function setPageObject(tslib_fe $pObj) {
		$this->page = $this->getPageRepository()->findOneByPageObject($pObj);
	}

	/**
	 * @param tslib_fe $pObj
	 * @return Tx_Asdis_Domain_Model_Page
	 */
	private function getPage(tslib_fe $pObj) {
		return $this->page;
	}

	/**
	 * @return Tx_Asdis_Domain_Repository_PageRepository
	 */
	private function getPageRepository() {
		return $this->getObjectManager()->get('Tx_Asdis_Domain_Repository_PageRepository');
	}
}