<?php

namespace Aoe\Asdis\Domain\Repository;

use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\Domain\Model\Server\Collection;
use Aoe\Asdis\Domain\Model\Server\Factory;
use Aoe\Asdis\System\Configuration\Provider;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Repository for server objects.
 */
class ServerRepository
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var Provider
     */
    private $configurationProvider;

    /**
     * @var Factory
     */
    private $serverFactory;

    /**
     * @param ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param Provider $configurationProvider
     */
    public function injectConfigurationProvider(Provider $configurationProvider)
    {
        $this->configurationProvider = $configurationProvider;
    }

    /**
     * @param Factory $serverFactory
     */
    public function injectServerFactory(Factory $serverFactory)
    {
        $this->serverFactory = $serverFactory;
    }

    public function findAllByPage(Page $page): Collection
    {
        /** @var Collection $servers */
        $servers = new Collection();
        $serverDefinitions = $this->configurationProvider->getServerDefinitions();
        foreach ($serverDefinitions as $serverDefinition) {
            $servers->append($this->serverFactory->createServer(
                $serverDefinition['identifier'],
                $serverDefinition['domain'],
                $serverDefinition['protocol']
            ));
        }
        return $servers;
    }
}
