<?php

namespace Aoe\Asdis\Domain\Model\DistributionAlgorithm;

use Aoe\Asdis\Domain\Model\Asset;
use Aoe\Asdis\Domain\Model\Asset\Collection as AssetCollection;
use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\Domain\Model\Server\Collection as ServerCollection;

/**
 * RoundRobin implementation of a distribution algorithm.
 */
class RoundRobin implements DistributionAlgorithmInterface
{
    private ?ServerCollection $servers = null;

    /**
     * Distributes the given assets to the given servers.
     */
    public function distribute(AssetCollection $assets, ServerCollection $servers): void
    {
        if ($servers->count() < 1) {
            return;
        }
        $this->servers = $servers;
        foreach ($assets as $asset) {
            /** @var Asset $asset */
            $asset->setServer($this->getNextServer());
        }
    }

    private function getNextServer(): Server
    {
        $server = $this->servers->current();
        $this->servers->next();
        if (!$this->servers->valid()) {
            $this->servers->rewind();
        }
        return $server;
    }
}
