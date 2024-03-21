<?php

namespace Aoe\Asdis\Domain\Repository;

use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\Domain\Model\Server\Collection;
use Aoe\Asdis\Domain\Model\Server\Factory;
use Aoe\Asdis\System\Configuration\Provider;

/**
 * Repository for server objects.
 * @see \Aoe\Asdis\Tests\Domain\Repository\ServerRepositoryTest
 */
class ServerRepository
{
    private ?Provider $configurationProvider = null;

    private ?Factory $serverFactory = null;

    public function injectConfigurationProvider(Provider $configurationProvider): void
    {
        $this->configurationProvider = $configurationProvider;
    }

    public function injectServerFactory(Factory $serverFactory): void
    {
        $this->serverFactory = $serverFactory;
    }

    public function findAllByPage(Page $page): Collection
    {
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
