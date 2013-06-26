<?php

/**
 * Provides all configuration settings.
 *
 * @package Tx_Asdis
 * @subpackage System_Configuration
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
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
		return (boolean) ((integer) $this->typoScriptConfiguration->getSetting('enabled'));
	}

	/**
	 * Returns the scraper keys for the current page.
	 *
	 * @return array
	 */
	public function getScraperKeys() {
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
	 * Returns the filter keys for the current page.
	 *
	 * @return array
	 */
	public function getFilterKeys() {
		$keyList = $this->typoScriptConfiguration->getSetting('filters', 'string');
		$keys    = explode(",", $keyList);
		if (FALSE === is_array($keys) || sizeof($keys) < 1) {
			return array();
		}
		$filterKeys = array();
		foreach ($keys as $key) {
			$filterKeys[] = trim($key);
		}
		return $filterKeys;
	}

	/**
	 * Returns an array like this:
	 * array(
	 *     array(
	 *         'identifier' => 'media1',
	 *         'domain'     => 'm1.mydomain.com'
	 *     ),
	 *     array(
	 *         'identifier' => 'media2',
	 *         'domain'     => 'm2.mydomain.com'
	 *     )
	 * )
	 *
	 * @return array
	 * @throws Tx_Asdis_System_Configuration_Exception_InvalidStructure
	 */
	public function getServerDefinitions() {
		$definitions = array();
		$serverDefinitions = $this->typoScriptConfiguration->getSetting('servers', 'array', TRUE);
		foreach($serverDefinitions as $identifier => $serverDefinition) {
			if(FALSE === is_array($serverDefinition) || FALSE === isset($serverDefinition['domain'])) {
				throw new Tx_Asdis_System_Configuration_Exception_InvalidStructure(
					'Configured server definition for "'.((string) $serverDefinition) . '" is invalid.',
					1372159113552
				);
			}
			$definitions[] = array(
				'identifier' => $identifier,
				'domain'     => $serverDefinition['domain']
			);
		}
		return $definitions;
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

	/**
	 * @param integer $loggerBackend
	 * @return array
	 */
	public function getLoggerBackendConfiguration($loggerBackend) {
		return $this->typoScriptConfiguration->getSetting('logger.backend.'.$loggerBackend, 'array', TRUE);
	}
}