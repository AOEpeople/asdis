<?php

class Tx_Asdis_System_Configuration_Provider {

	/**
	 * @var Tx_Asdis_System_Configuration_TypoScriptConfiguration
	 */
	private $typoScriptConfiguration;

	/**
	 * @param Tx_Asdis_System_Configuration_TypoScriptConfiguration $typoScriptConfiguration
	 */
	public function injectTypoScriptConfiguration(Tx_Asdis_System_Configuration_TypoScriptConfiguration $typoScriptConfiguration) {
		$this->typoScriptConfiguration = $typoScriptConfiguration;
	}

	/**
	 * Tells if the assets on the current page should be replaced.
	 *
	 * @return boolean
	 */
	public function isReplacementEnabled() {
		return (boolean) $this->typoScriptConfiguration->getSetting('enabled');
	}

	/**
	 * @return array
	 */
	public function getScraperKeys() {

		return array('htmlImage');

		$keyList = $this->typoScriptConfiguration->getSetting('scrapers', 'string');
		$keys    = explode(",", $keyList);
		if (FALSE === is_array($keys) || sizeof($keys) < 1) {
			return array();
		}
		$scraperKeys = array();
		foreach ($keys as $key) {
			$scraperKeys[] = trim($key);
		}
		return $scraperKeys;
	}

	/**
	 * @return integer
	 */
	public function getLoggerSeverity() {
		return (integer) $this->typoScriptConfiguration->getSetting('logger.severity', 'string');
	}

	/**
	 * @return integer
	 */
	public function getSyslogSeverity() {
		return (integer) $this->typoScriptConfiguration->getSetting('logger.syslogSeverity', 'string');
	}
}