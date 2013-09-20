<?php

/**
 * System logger.
 *
 * @package Tx_Asdis
 * @subpackage System_Log
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Log_Logger implements t3lib_Singleton {

	/**
	 * @param string $context
	 * @param Exception $e
	 */
	public function logException($context, Exception $e) {
		$this->syslog(
			$context,
			'Exception occured ' . PHP_EOL .
			'  Code:    ' . $e->getCode() . PHP_EOL .
			'  Message: "' . $e->getMessage() . '"' . PHP_EOL .
			'  Trace:' . PHP_EOL . $e->getTraceAsString(),
			4
		);
	}

	/**
	 * @param string $message
	 * @param integer $severity
	 */
	private function syslog($message, $severity) {
		t3lib_div::sysLog($message, 'asdis', $severity);
	}
}