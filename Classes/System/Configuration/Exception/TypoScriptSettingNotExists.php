<?php

/**
 * Exception which is thrown when a requested TypoScript setting does not exist.
 *
 * @package Tx_Asdis
 * @subpackage System_Configuration_Exception
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Configuration_Exception_TypoScriptSettingNotExists extends Exception {

	/**
	 * @param string $settingsKey
	 * @param integer $code
	 */
	public function __construct($settingsKey, $code) {
		parent::__construct('TypoScript setting "' . $settingsKey . '" does not exist.', $code);
	}
}