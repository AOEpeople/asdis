<?php
namespace Aoe\Asdis\System\Configuration;

use Aoe\Asdis\System\Configuration\Exception\InvalidTypoScriptSetting;
use Aoe\Asdis\System\Configuration\Exception\TypoScriptSettingNotExists;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * TypoScript configuration provider.
 */
class TypoScriptConfiguration implements SingletonInterface 
{
    /**
     * @var array
     */
    private $configuration;

    /**
     * @var array
     */
    private $configurationCache = [];

    /**
     * @param string $key The setting key. E.g. "logger.severity"
     * @param string $validateType The data type to be validated against (E.g. "string"). Empty string to skip validation.
     * @param boolean $hasSubkeys Tells whether the requested key is assumed to has subkeys.
     * @return mixed
     * @throws \Aoe\Asdis\System\Configuration\Exception\InvalidTypoScriptSetting
     * @throws \Aoe\Asdis\System\Configuration\Exception\TypoScriptSettingNotExists
     */
    public function getSetting($key, $validateType = '', $hasSubkeys = false)
    {
        if (isset($this->configurationCache[$key])) {
            return $this->configurationCache[$key];
        }
        $parts = explode('.', $key);
        if (false === is_array($parts) || sizeof($parts) < 1) {
            throw new TypoScriptSettingNotExists($key, 1372050700894);
        }
        $conf = $this->getTypoScriptConfigurationArray();
        $lastPartIndex = sizeof($parts) - 1;
        foreach($parts as $index => $part) {
            $subkey = $part;
            if ($lastPartIndex !== $index || $hasSubkeys) {
                $subkey .= '.';
            }
            if (false === isset($conf[$subkey])) {
                throw new TypoScriptSettingNotExists($key, 1372063884313);
            }
            $conf = $conf[$subkey];
            if ($lastPartIndex === $index) {
                break;
            }
        }
        if (strlen($validateType) > 0 && strcmp($validateType, gettype($conf)) !== 0) {
            throw new InvalidTypoScriptSetting($key, gettype($conf), 1372064668444);
        }
        $this->configurationCache[$key] = $conf;
        return $conf;
    }

    /**
     * @return array
     */
    protected function getTypoScriptConfigurationArray()
    {
        return $GLOBALS['TSFE']->tmpl->setup['config.']['tx_asdis.'];
    }
}