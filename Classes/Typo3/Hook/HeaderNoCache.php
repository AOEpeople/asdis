<?php

/**
 * Handles hook HeaderNoCache.
 *
 * @package Tx_Asdis
 * @subpackage Typo3_Hook
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Typo3_Hook_HeaderNoCache extends Tx_Asdis_Typo3_Hook_AbstractHook {

	/**
	 * Clears the page cache.
	 *
	 * @param array $params
	 * @param tslib_fe $pObj
	 * @return void
	 */
	public function process(&$params, tslib_fe &$pObj) {
		if($this->getCrawler()->isCrawlerProcessingInstructionActive(Tx_Asdis_Typo3_Crawler::PUBLISH_PROCESSING_INSTRUCTION, $pObj)) {
			$pObj->all = '';
		}
	}
}