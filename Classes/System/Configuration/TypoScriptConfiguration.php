<?php

namespace Aoe\Asdis\System\Configuration;

use Aoe\Asdis\System\Configuration\Exception\InvalidTypoScriptSetting;
use Aoe\Asdis\System\Configuration\Exception\SiteNotFoundException;
use Aoe\Asdis\System\Configuration\Exception\TypoScriptSettingNotExists;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\TypoScript\TemplateService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

/**
 * TypoScript configuration provider.
 * @see \Aoe\Asdis\Tests\System\Configuration\TypoScriptConfigurationTest
 */
class TypoScriptConfiguration implements SingletonInterface
{
    private array $configurationCache = [];

    /**
     * @param string $key The setting key. E.g. "logger.severity"
     * @param string $validateType The data type to be validated against (E.g. "string"). Empty string to skip validation.
     * @param boolean $hasSubkeys Tells whether the requested key is assumed to has subkeys.
     * @return mixed
     */
    public function getSetting($key, $validateType = '', $hasSubkeys = false)
    {
        if (isset($this->configurationCache[$key])) {
            return $this->configurationCache[$key];
        }

        $parts = explode('.', $key);
        if (!is_array($parts) || count($parts) < 1) {
            throw new TypoScriptSettingNotExists($key, 1_372_050_700_894);
        }

        $conf = $this->getTypoScriptConfigurationArray();
        $lastPartIndex = count($parts) - 1;
        foreach ($parts as $index => $part) {
            $subkey = $part;
            if ($lastPartIndex !== $index || $hasSubkeys) {
                $subkey .= '.';
            }

            if (!isset($conf[$subkey])) {
                throw new TypoScriptSettingNotExists($key, 1_372_063_884_313);
            }

            $conf = $conf[$subkey];
            if ($lastPartIndex === $index) {
                break;
            }
        }

        if (strlen($validateType) > 0 && strcmp($validateType, gettype($conf)) !== 0) {
            throw new InvalidTypoScriptSetting($key, gettype($conf), 1_372_064_668_444);
        }

        $this->configurationCache[$key] = $conf;
        return $conf;
    }

    /**
     * @return array
     */
    protected function getTypoScriptConfigurationArray()
    {
        if (version_compare(VersionNumberUtility::getCurrentTypo3Version(), '9.5.0', '<')) {
            return $GLOBALS['TSFE']->tmpl->setup['config.']['tx_asdis.'];
        }

        $site = $this->getCurrentSite();

        /** @var RootlineUtility $rootlineUtility */
        $rootlineUtility = GeneralUtility::makeInstance(RootlineUtility::class, $site->getRootPageId());
        $rootline = $rootlineUtility->get();
        /** @var TemplateService $templateService */
        $templateService = GeneralUtility::makeInstance(TemplateService::class);
        $templateService->tt_track = false;
        $templateService->runThroughTemplates($rootline);
        $templateService->generateConfig();

        return $templateService->setup['config.']['tx_asdis.'];
    }

    /**
     * @return Site
     */
    protected function getCurrentSite()
    {
        if ($GLOBALS['TYPO3_REQUEST'] === null) {
            $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
            $requestUrl = GeneralUtility::getIndpEnv('HTTP_HOST');
            $allSites = $siteFinder->getAllSites();
            foreach ($allSites as $site) {
                if ($site->getBase()->getHost() === $requestUrl) {
                    return $site;
                }
            }

            throw new SiteNotFoundException();
        }

        return $GLOBALS['TYPO3_REQUEST']->getAttribute('site');
    }
}
