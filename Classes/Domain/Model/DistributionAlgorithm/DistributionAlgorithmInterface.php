<?php

namespace Aoe\Asdis\Domain\Model\DistributionAlgorithm;

use Aoe\Asdis\Domain\Model\Asset\Collection as AssetCollection;
use Aoe\Asdis\Domain\Model\Server\Collection as ServerCollection;

/**
 * Common interface for all distribution algorithms.
 */
interface DistributionAlgorithmInterface
{
    /**
     * Distributes the given assets to the given servers.
     */
    public function distribute(AssetCollection $assets, ServerCollection $servers): void;
}
