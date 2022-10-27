<?php

namespace Aoe\Asdis\Domain\Model\Asset;

use Aoe\Asdis\Content\Replacement\Map;
use Aoe\Asdis\Domain\Model\Asset;
use Aoe\Asdis\Domain\Model\Asset\Collection as AssetCollection;

/**
 * Collection which contains asset objects.
 */
class Collection extends \ArrayIterator
{
    private array $elementHashes = [];

    /**
     * Needs to be called due to an extbase bug.
     * Hides optional parameters of parent constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Asset $asset
     */
    public function append($asset)
    {
        $elementHash = $asset->getHash();
        if (in_array($elementHash, $this->elementHashes)) {
            return;
        }
        $this->elementHashes[] = $elementHash;
        parent::append($asset);
    }

    public function merge(AssetCollection $assetCollection): self
    {
        foreach ($assetCollection as $asset) {
            $this->append($asset);
        }
        return $this;
    }

    public function getReplacementMap(): Map
    {
        $map = new Map();
        foreach ($this as $asset) {
            /** @var Asset $asset */
            $map->addMapping(
                $asset->getMaskedPregQuotedOriginalPath(),
                $asset->getMask() . $asset->getUri() . $asset->getMask()
            );
        }
        return $map;
    }
}
