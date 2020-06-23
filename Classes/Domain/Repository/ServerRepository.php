<?php
namespace Aoe\Asdis\Domain\Repository;

use Aoe\Asdis\Domain\Model\Server\Collection;
use Aoe\Asdis\Domain\Model\Server\Factory;
use Aoe\Asdis\System\Configuration\Provider;

/**
 * Repository for server objects.
 */
class ServerRepository
{
    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var \Aoe\Asdis\System\Configuration\Provider
     */
    private $configurationProvider;

    /**
     * @var \Aoe\Asdis\Domain\Model\Server\Factory
     */
    private $serverFactory;

    /**
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param \Aoe\Asdis\System\Configuration\Provider $configurationProvider
     */
    public function injectConfigurationProvider(Provider $configurationProvider)
    {
        $this->configurationProvider = $configurationProvider;
    }

    /**
     * @param \Aoe\Asdis\Domain\Model\Server\Factory $serverFactory
     */
    public function injectServerFactory(Factory $serverFactory)
    {
        $this->serverFactory = $serverFactory;
    }

    /**
     * @param \Aoe\Asdis\Domain\Model\Page $page
     * @return \Aoe\Asdis\Domain\Model\Server\Collection
     */
    public function findAllByPage(\Aoe\Asdis\Domain\Model\Page $page)
    {
        /** @var \Aoe\Asdis\Domain\Model\Server\Collection $servers */
        $servers = new Collection();
        $serverDefinitions = $this->configurationProvider->getServerDefinitions();
        foreach($serverDefinitions as $serverDefinition) {
            $servers->append($this->serverFactory->createServer(
                $serverDefinition['identifier'],
                $serverDefinition['domain'],
                $serverDefinition['protocol']
            ));
        }
        return $servers;
    }

}