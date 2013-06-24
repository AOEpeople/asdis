<?php

/**
 * System logger.
 *
 * @package Tx_Asdis
 * @subpackage System_Log
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Log_Logger {

	const SEVERITY_INFO = 1;

	/**
	 * @var Tx_Asdis_System_Log_BackendInterface
	 */
	private $backend;

	/**
	 * @param Tx_Asdis_System_Log_BackendInterface $backend
	 */
	public function injectBackend(Tx_Asdis_System_Log_BackendInterface $backend) {
		$this->backend = $backend;
	}

	/**
	 * @param string $context
	 * @param string $message
	 * @param string $severity
	 * @return void
	 */
	public function log($context, $message, $severity = Tx_Asdis_System_log_Logger::SEVERITY_INFO) {
		$this->backend->log($context, $message, $severity);
	}
}