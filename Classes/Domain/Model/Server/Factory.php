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
        } catch (Exception) {
            $this->protocolMarker = '';
        }
    }

    public function createServer(string $identifier, string $domain, string $protocol): Server
    {
        $server = GeneralUtility::makeInstance(Server::class);
        $server->setIdentifier($identifier);
        $server->setDomain($domain);
        $server->setProtocol($protocol);
        $server->setProtocolMarker($this->protocolMarker);
        return $server;
    }
}
