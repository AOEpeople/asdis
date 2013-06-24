<?php

/**
 * Logs to a file.
 *
 * @package Tx_Asdis
 * @subpackage System_Log
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Log_FileBackend implements Tx_Asdis_System_Log_BackendInterface {

	/**
	 * @param string $context
	 * @param string $message
	 * @param string $severity
	 * @return void
	 */
	public function log($context, $message, $severity) {
		file_put_contents(
			'/home/timo.fuchs/log.log',
			strftime("%F %R").' - '.$context.' : '.$message.PHP_EOL,
			FILE_APPEND
		);
	}
}