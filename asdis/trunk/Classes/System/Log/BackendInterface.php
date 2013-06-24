<?php

/**
 * Interface which has to be implemented by concrete logger backends.
 *
 * @package Tx_Asdis
 * @subpackage System_Log
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
interface Tx_Asdis_System_Log_BackendInterface {

	/**
	 * @param string $context
	 * @param string $message
	 * @param string $severity
	 * @return void
	 */
	public function log($context, $message, $severity);
}