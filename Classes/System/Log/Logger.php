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
	 * @var integer
	 */
	private $severity;

	/**
	 * @var integer
	 */
	private $syslogSeverity;

	/**
	 * @var Tx_Asdis_System_Configuration_Provider
	 */
	private $configurationProvider;

	/**
	 * @var Tx_Asdis_System_Log_BackendInterface
	 */
	private $backend;

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * @var boolean
	 */
	private $isInitialized = FALSE;

	/**
	 * @param Tx_Asdis_System_Configuration_Provider $configurationProvider
	 */
	public function injectConfigurationProvider(Tx_Asdis_System_Configuration_Provider $configurationProvider) {
		$this->configurationProvider = $configurationProvider;
	}

	/**
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * @param string $context
	 * @param string $message
	 * @param integer $severity
	 * @return void
	 */
	public function log($context, $message, $severity = Tx_Asdis_System_Log_Severity::INFO) {
		if(FALSE === $this->isInitialized) {
			$this->initialize();
		}
		if($severity >= $this->syslogSeverity) {
			$this->syslog($context . ' - ' . $message, $severity);
		}
		if($severity < $this->severity) {
			return;
		}
		$this->backend->log($context, $message, $severity);
	}

	/**
	 * We have to use this initialization method because the TypoScript configuration is not available when dependencies
	 * are injected.
	 *
	 * @return void
	 */
	private function initialize() {
		$this->severity       = $this->configurationProvider->getLoggerSeverity();
		$this->syslogSeverity = $this->configurationProvider->getSyslogSeverity();
		$this->backend        = $this->objectManager->get('Tx_Asdis_System_Log_BackendInterface');
		try {
			$this->backend->setConfiguration($this->configurationProvider->getLoggerBackendConfiguration(
				$this->getBackendTypeByClassname(get_class($this->backend)))
			);
		} catch (Exception $e) {
			throw $e;
		}
		$this->isInitialized = TRUE;
	}

	/**
	 * @param string $context
	 * @param Exception $e
	 */
	public function logException($context, Exception $e) {
		$this->log(
			$context,
			'Exception occured ' . PHP_EOL .
			'  Code:    ' . $e->getCode() . PHP_EOL .
			'  Message: "' . $e->getMessage() . '"' . PHP_EOL .
			'  Trace:' . PHP_EOL . $e->getTraceAsString(),
			Tx_Asdis_System_Log_Severity::FATAL_ERROR
		);
	}

	/**
	 * @param string $message
	 * @param integer $severity
	 */
	private function syslog($message, $severity) {
		t3lib_div::sysLog($message, 'asdis', $severity);
	}

	/**
	 * @param string $backendClassname
	 * @return string
	 */
	private function getBackendTypeByClassname($backendClassname) {
		return strtolower(str_replace('Backend', '', substr($backendClassname, strrpos($backendClassname, '_') + 1)));
	}
}