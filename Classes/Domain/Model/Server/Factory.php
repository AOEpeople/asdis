<?php
namespace Aoe\Asdis\Domain\Model\Server;

use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\System\Configuration\Provider;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Factory for server objects.
 */
class Factory
{
    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var string
     */
    private $protocolMarker;

    /**
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param \Aoe\Asdis\System\Configuration\Provider $configurationProvider
     */
    public function injectConfigurationProvider(Provider $configurationProvider)
    {
        try {
            $this->protocolMarker = $configurationProvider->getServerProtocolMarker();
        } catch(\Exception $e) {
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
        /** @var \Aoe\Asdis\Domain\Model\Server $server */
        $server = $this->objectManager->get(Server::class);
        $server->setIdentifier($identifier);
        $server->setDomain($domain);
        $server->setProtocol($protocol);
        $server->setProtocolMarker($this->protocolMarker);
        return $server;
    }
}