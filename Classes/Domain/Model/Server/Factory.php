<?php

namespace Aoe\Asdis\Domain\Model\Server;

use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\System\Configuration\Provider;
use Exception;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Factory for server objects.
 * @see \Aoe\Asdis\Tests\Domain\Model\Server\FactoryTest
 */
class Factory
{
    private ?string $protocolMarker = '';

    public function injectConfigurationProvider(Provider $configurationProvider): void
    {
        try {
            $this->protocolMarker = $configurationProvider->getServerProtocolMarker();
        } catch (Exception $exception) {
            $this->protocolMarker = '';
        }
    }

    /**
     * @param string $identifier
     * @param string $domain
     * @param string $protocol
     * @return \Aoe\Asdis\Domain\Model\Server
     */
    public function createServer($identifier, $domain, $protocol)
    {
        $server = GeneralUtility::makeInstance(Server::class);
        $server->setIdentifier($identifier);
        $server->setDomain($domain);
        $server->setProtocol($protocol);
        $server->setProtocolMarker($this->protocolMarker);
        return $server;
    }
}
