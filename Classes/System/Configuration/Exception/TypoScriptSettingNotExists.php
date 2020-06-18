<?php
namespace Aoe\Asdis\System\Configuration\Exception;

/**
 * Exception which is thrown when a requested TypoScript setting does not exist.
 */
class TypoScriptSettingNotExists extends \Exception
{
    /**
     * @param string $settingsKey
     * @param integer $code
     */
    public function __construct($settingsKey, $code)
    {
        parent::__construct('TypoScript setting "' . $settingsKey . '" does not exist.', $code);
    }
}