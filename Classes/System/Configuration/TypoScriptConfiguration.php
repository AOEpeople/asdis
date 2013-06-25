<?php

/**
 * TypoScript configuration provider.
 *
 * @package Tx_Asdis
 * @subpackage System_Configuration
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Configuration_TypoScriptConfiguration implements t3lib_Singleton {

	/**
	 * @var array
	 */
	private $configuration;

	/**
	 * @var array
	 */
	private $configurationCache = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->initializeTypoScriptConfiguration();
	}

	/**
	 * @param string $key The setting key. E.g. "logger.severity"
	 * @param string $validateType The data type to be validated against (E.g. "string"). Empty string to skip validation.
	 * @param boolean $hasSubkeys Tells whether the requested key is assumed to has subkeys.
	 * @return mixed
	 * @throws Tx_Asdis_System_Configuration_Exception_InvalidTypoScriptSetting
	 * @throws Tx_Asdis_System_Configuration_Exception_TypoScriptSettingNotExists
	 */
	public function getSetting($key, $validateType = '', $hasSubkeys = FALSE) {
		if(isset($this->configurationCache[$key])) {
			return $this->configurationCache[$key];
		}
		$parts = explode(".", $key);
		if(FALSE === is_array($parts) || sizeof($parts) < 1) {
			throw new Tx_Asdis_System_Configuration_Exception_TypoScriptSettingNotExists($key, 1372050700894);
		}
		$conf = $this->configuration;
		$lastPartIndex = sizeof($parts) - 1;
		foreach($parts as $index => $part) {
			$subkey = $part;
			if($lastPartIndex !== $index || $hasSubkeys) {
				$subkey .= '.';
			}
			if(FALSE === isset($conf[$subkey])) {
				throw new Tx_Asdis_System_Configuration_Exception_TypoScriptSettingNotExists($key, 1372063884313);
			}
			$conf = $conf[$subkey];
			if($lastPartIndex === $index) {
				break;
			}
		}
		if(strlen($validateType) > 0 && strcmp($validateType, gettype($conf)) !== 0) {
			throw new Tx_Asdis_System_Configuration_Exception_InvalidTypoScriptSetting($key, gettype($conf), 1372064668444);
		}
		$this->configurationCache[$key] = $conf;
		return $conf;
	}

	/**
	 * Initializes the TypoScript configuration array.
	 *
	 * @return void
	 */
	private function initializeTypoScriptConfiguration() {
		$this->configuration = array();
		if (TYPO3_MODE !== 'FE') {
			return;
		}
		$this->configuration = $GLOBALS['TSFE']->tmpl->setup['config.']['tx_asdis.'];
	}
}