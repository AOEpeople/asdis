<?php

/**
 * @package Tx_Asdis
 * @subpackage Typo3_Hook
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Typo3_Hook_ContentPostProcAll extends Tx_Asdis_Typo3_Hook_AbstractHook {

	/**
	 * Stores resources in cloud when crawler is active.
	 *
	 * @param array $params
	 * @param tslib_fe $pObj
	 * @return void
	 */
	public function process(&$params, tslib_fe &$pObj = NULL) {
		if (NULL === $pObj) {
			if (isset($params['pObj']) && ($params['pObj'] instanceof tslib_fe)) {
				$pObj = $params['pObj'];
			} else {
				$pObj = $GLOBALS['TSFE'];
			}
		}

		if ($this->getCrawler()->isCrawlerProcessingInstructionActive(Tx_Asdis_Typo3_Crawler::PUBLISH_PROCESSING_INSTRUCTION, $pObj)) {
			//Tx_Cdn_Typo3_HookListener::onTriggeredResynchronize($pObj);
		}
		//die('x');
		//$this->replaceAssets($pObj);
		$this->scrapeAssets($pObj);
	}
}