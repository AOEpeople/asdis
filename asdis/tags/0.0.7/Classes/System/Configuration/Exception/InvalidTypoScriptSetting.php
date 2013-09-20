<?php

/**
 * Exception which is thrown when a requested TypoScript setting is invalid.
 *
 * @package Tx_Asdis
 * @subpackage System_Configuration_Exception
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Configuration_Exception_InvalidTypoScriptSetting extends Exception {

	/**
	 * @param string $key Setting key. E.g. "logger.severity".
	 * @param string $type The actual data type of the setting.
	 * @param integer $code Exception code.
	 */
	public function __construct($key, $type, $code) {
		parent::__construct('Invalid TypoScript Setting "'.$key.'". Type is "'.$type.'".', $code);
	}
}