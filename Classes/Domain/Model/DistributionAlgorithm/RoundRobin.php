<?php
namespace Aoe\Asdis\Domain\Model\DistributionAlgorithm;

use Aoe\Asdis\Domain\Model\Asset\Collection as AssetCollection;
use Aoe\Asdis\Domain\Model\DistributionAlgorithm\DistributionAlgorithmInterface;
use Aoe\Asdis\Domain\Model\Server\Collection as ServerCollection;

/**
 * RoundRobin implementation of a distribution algorithm.
 */
class RoundRobin implements DistributionAlgorithmInterface
{
    /**
     * @var \Aoe\Asdis\Domain\Model\Server\Collection
     */
    private $servers;

    /**
     * Distributes the given assets to the given servers.
     *
     * @param \Aoe\Asdis\Domain\Model\Asset\Collection $assets
     * @param \Aoe\Asdis\Domain\Model\Server\Collection $servers
     * @return void
     */
    public function distribute(AssetCollection $assets, ServerCollection $servers)
    {
        if ($servers->count() < 1) {
            return;
        }
        $this->servers = $servers;
        foreach($assets as $asset) {
            /** @var \Aoe\Asdis\Domain\Model\Asset $asset */
            $asset->setServer($this->getNextServer());
        }
    }

    /**
     * @return \Aoe\Asdis\Domain\Model\Server
     */
    private function getNextServer()
    {
        $server = $this->servers->current();
        $this->servers->next();
        if (false === $this->servers->valid()) {
            $this->servers->rewind();
        }
        return $server;
    }
}