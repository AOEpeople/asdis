<?php

abstract class Tx_Asdis_Typo3_Hook_AbstractHook {

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * @var Tx_Asdis_Typo3_Crawler
	 */
	private $crawler;

	/**
	 * @return Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected function getObjectManager() {
		if(FALSE === isset($this->objectManager)) {
			$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		}
		return $this->objectManager;
	}

	/**
	 * @return Tx_Asdis_Typo3_Crawler
	 */
	protected function getCrawler() {
		if(FALSE === isset($this->crawler)) {
			$this->crawler = $this->getObjectManager()->get('Tx_Asdis_Typo3_Crawler');
		}
		return $this->crawler;
	}

	/**
	 * @param tslib_fe $pObj
	 */
	protected function scrapeAssets(tslib_fe $pObj) {
		$page = $this->getPage($pObj);
		$page->scrapeAssets();
		$page->replaceAssets();
	}

	/**
	 * @param tslib_fe $pObj
	 */
	protected function replaceAssets(tslib_fe $pObj) {
		return;
		/** @var Tx_Asdis_Content_Processor $processor */
		$processor = $this->getObjectManager()->get('Tx_Asdis_Content_Processor');
		$processor->replaceAssets($pObj);
	}

	/**
	 * @param tslib_fe $pObj
	 * @return Tx_Asdis_Domain_Model_Page
	 */
	private function getPage(tslib_fe $pObj) {
		return $this->getPageRepository()->findOneByPageObject($pObj);
	}

	/**
	 * @return Tx_Asdis_Domain_Repository_PageRepository
	 */
	private function getPageRepository() {
		return $this->getObjectManager()->get('Tx_Asdis_Domain_Repository_PageRepository');
	}
}