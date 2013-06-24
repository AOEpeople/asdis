<?php

class Tx_Asdis_System_Configuration_Exception_TypoScriptSettingNotExists extends Exception {

	/**
	 * @param string $settingsKey
	 * @param integer $code
	 */
	public function __construct($settingsKey, $code) {
		parent::__construct('TypoScript setting "' . $settingsKey . '" does not exist.', $code);
	}
}