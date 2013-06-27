<?php

/**
 * Repository for page objects.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Repository
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Domain_Repository_PageRepository implements Tx_Asdis_Domain_Repository_PageRepositoryInterface {

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * @param tslib_fe $pageObject
	 * @return Tx_Asdis_Domain_Model_Page
	 */
	public function findOneByPageObject(tslib_fe $pageObject) {
		/** @var Tx_Asdis_Domain_Model_Page $page */
		$page = $this->objectManager->create('Tx_Asdis_Domain_Model_Page');
		$page->setPageObject($pageObject);
		$page->setAssets($this->objectManager->create('Tx_Asdis_Domain_Model_Asset_Collection'));
		return $page;
	}
}