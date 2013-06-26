<?php

/**
 * Null logger backend which won't log anything.
 *
 * @package Tx_Asdis
 * @subpackage System_Log
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Log_NullBackend implements Tx_Asdis_System_Log_BackendInterface {

	/**
	 * @param string $context
	 * @param string $message
	 * @param string $severity
	 * @return void
	 */
	public function log($context, $message, $severity) { }

	/**
	 * @param array $configuration
	 * @return void
	 */
	public function setConfiguration(array $configuration) { }
}