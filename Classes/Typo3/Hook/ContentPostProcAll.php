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
		try {
			$this->setPageObject($pObj);
			$this->getLogger()->log(__METHOD__, 'processing');
			$this->scrapeAndReplace();
		} catch(Exception $e) {
			$this->getLogger()->logException(__METHOD__, $e);
		}
	}
}