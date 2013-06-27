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
	 * @var string
	 */
	private $logfile;

	/**
	 * @param string $context
	 * @param string $message
	 * @param integer $severity
	 * @throws Tx_Asdis_System_Log_Exception_LoggingNotPossible
	 * @return void
	 */
	public function log($context, $message, $severity) {
		$success = file_put_contents(
			$this->getLogfile(),
			strftime("%F %T"). ' ' . $this->severityToString($severity) . ' - '.$context.' : '.$message.PHP_EOL,
			FILE_APPEND
		);
		if($success === FALSE) {
			throw new Tx_Asdis_System_Log_Exception_LoggingNotPossible(
				'Could not log to file backend.',
				1372175968452
			);
		}
	}

	/**
	 * @param array $configuration
	 * @throws Tx_Asdis_System_Log_Exception_LoggingNotPossible
	 * @return void
	 */
	public function setConfiguration(array $configuration) {
		if(FALSE === isset($configuration['path'])) {
			throw new Tx_Asdis_System_Log_Exception_LoggingNotPossible(
				'Logfile configuration missing for file backend.',
				1372176065730
			);
		}
		$this->logfile = $configuration['path'];
	}

	/**
	 * @return string
	 * @throws Tx_Asdis_System_Log_Exception_LoggingNotPossible
	 */
	protected function getLogfile() {
		if(FALSE === isset($this->logfile)) {
			throw new Tx_Asdis_System_Log_Exception_LoggingNotPossible(
				'No logfile available for file backend.',
				1372175876081
			);
		}
		return $this->logfile;
	}

	/**
	 * @param integer $severity
	 * @return string
	 */
	private function severityToString($severity) {
		$str = '';
		switch($severity) {
			case Tx_Asdis_System_Log_Severity::INFO :
				$str = '[INFO]   ';
				break;
			case Tx_Asdis_System_Log_Severity::NOTICE :
				$str = '[NOTICE] ';
				break;
			case Tx_Asdis_System_Log_Severity::WARNING :
				$str = '[WARNING]';
				break;
			case Tx_Asdis_System_Log_Severity::ERROR :
				$str = '[ERROR]  ';
				break;
			case Tx_Asdis_System_Log_Severity::FATAL_ERROR :
				$str = '[FATAL]  ';
		}
		return $str;
	}
}