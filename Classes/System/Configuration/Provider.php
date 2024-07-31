<?php

namespace Aoe\Asdis\System\Configuration;

use Aoe\Asdis\System\Configuration\Exception\InvalidStructure;

/**
 * Provides all configuration settings.
 */
class Provider
{
    private ?TypoScriptConfiguration $typoScriptConfiguration = null;

    public function __construct(TypoScriptConfiguration $typoScriptConfiguration)
    {
        $this->typoScriptConfiguration = $typoScriptConfiguration;
    }

    /**
     * Tells if the assets on the current page should be replaced.
     */
    public function isReplacementEnabled(): bool
    {
        return (bool) ((int) $this->typoScriptConfiguration->getSetting('enabled'));
    }

    /**
     * This disables any processing in hook handlers of the asdis extension.
     * You can use this, if you have to implement your own hook processing in another extension.
     */
    public function isDefaultHookHandlingDisabled(): bool
    {
        return (bool) ((int) $this->typoScriptConfiguration->getSetting('disableDefaultHookHandling'));
    }

    public function getDistributionAlgorithmKey(): string
    {
        return (string) $this->typoScriptConfiguration->getSetting('distributionAlgorithm');
    }

    /**
     * Returns the scraper keys for the current page.
     */
    public function getScraperKeys(): array
    {
        $keyList = $this->typoScriptConfiguration->getSetting('scrapers', 'string');
        $keys = explode(',', $keyList);

        if (!is_array($keys)) {
            return [];
        }

        if (count($keys) < 1) {
            return [];
        }

        $scraperKeys = [];
        foreach ($keys as $key) {
            $scraperKeys[] = trim($key);
        }

        return $scraperKeys;
    }

    /**
     * Returns the filter keys for the current page.
     */
    public function getFilterKeys(): array
    {
        $keyList = $this->typoScriptConfiguration->getSetting('filters', 'string');
        $keys = explode(',', $keyList);

        if (!is_array($keys)) {
            return [];
        }

        if (count($keys) < 1) {
            return [];
        }

        $filterKeys = [];
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
     *         'domain'     => 'm1.mydomain.com',
     *         'protocol'   => 'dynamic'
     *     ),
     *     array(
     *         'identifier' => 'media2',
     *         'domain'     => 'm2.mydomain.com',
     *         'protocol'   => 'http'
     *     )
     * )
     */
    public function getServerDefinitions(): array
    {
        $definitions = [];
        $serverDefinitions = $this->typoScriptConfiguration->getSetting('servers', 'array', true);
        foreach ($serverDefinitions as $identifier => $serverDefinition) {
            if (!is_array($serverDefinition) || !isset($serverDefinition['domain'])) {
                throw new InvalidStructure(
                    'Configured server definition for "' . $serverDefinition . '" is invalid.',
                    1_372_159_113_552
                );
            }

            if (!isset($serverDefinition['protocol'])) {
                $serverDefinition['protocol'] = 'marker';
            }

            $definitions[] = [
                'identifier' => $identifier,
                'domain' => $serverDefinition['domain'],
                'protocol' => $serverDefinition['protocol'],
            ];
        }

        return $definitions;
    }

    public function getServerProtocolMarker(): string
    {
        return $this->typoScriptConfiguration->getSetting('serverProtocolMarker', 'string');
    }
}
