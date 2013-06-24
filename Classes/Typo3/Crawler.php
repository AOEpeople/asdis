<?php

/**
 * Provides runtime information about the crawler extension.
 *
 * @package Tx_Asdis
 * @subpackage Typo3
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Typo3_Crawler {

	/**
	 * @var string
	 */
	const PUBLISH_PROCESSING_INSTRUCTION = 'tx_asdis_publish';

	/**
	 * Tells if the crawler extension is loaded.
	 *
	 * @return boolean
	 */
	public function isLoaded() {
		return t3lib_extMgm::isLoaded('crawler');
	}

	/**
	 * Tells if the rendering of the current page was invoked by crawler.
	 *
	 * @return boolean
	 */
	public function isRunnning(tslib_fe $pObj) {
		return (
			isset($pObj->applicationData['tx_crawler']) &&
			is_array($pObj->applicationData['tx_crawler']) &&
			isset($pObj->applicationData['tx_crawler']['running'])
		);
	}

	/**
	 * Tells if the given processing instruction is active for the current FE page call.
	 *
	 * @param string $processingInstruction
	 * @param tslib_fe $pObj
	 * @return boolean
	 */
	public function isCrawlerProcessingInstructionActive($processingInstruction, tslib_fe &$pObj) {
		if (
			$this->isLoaded() && $this->isRunnning($pObj) &&
			isset($pObj->applicationData['tx_crawler']['parameters']) &&
			isset($pObj->applicationData['tx_crawler']['parameters']['procInstructions']) &&
			in_array($processingInstruction, $pObj->applicationData['tx_crawler']['parameters']['procInstructions'])
		) {
			return TRUE;
		}
		return FALSE;
	}
}