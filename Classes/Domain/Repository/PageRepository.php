<?php

class Tx_Asdis_Domain_Repository_PageRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	//private $objectManager;

	/**
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 */
	/*public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}*/

	/**
	 * @param tslib_fe $pageObject
	 * @return Tx_Asdis_Domain_Model_Page
	 * @todo implement
	 */
	public function findOneByPageObject(tslib_fe $pageObject) {
		/** @var Tx_Asdis_Domain_Model_Page $page */
		$page = $this->objectManager->create('Tx_Asdis_Domain_Model_Page');
		$page->setPageObject($pageObject);
		$page->setAssets(new Tx_Asdis_Domain_Model_Asset_Collection()); // @todo fetch assets
		return $page;
	}
}