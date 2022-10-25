<?php

namespace Aoe\Asdis\Domain\Model\DistributionAlgorithm;

use Aoe\Asdis\Domain\Model\Asset;
use Aoe\Asdis\Domain\Model\Asset\Collection as AssetCollection;
use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\Domain\Model\Server\Collection as ServerCollection;

/**
 * A distribution algorithm which is based on the assets hashed filenames.
 */
class HashBasedGroups implements DistributionAlgorithmInterface
{
    /**
     * @var string
     */
    public const UNKNOWN_GROUP_KEY = 'unknown';

    /**
     * @var ServerCollection
     */
    private $servers;

    /**
     * @var string
     */
    private $characters = '0123456789abcdef';

    /**
     * @var array
     */
    private $groups;

    /**
     * Distributes the given assets to the given servers.
     *
     * @param AssetCollection $assets
     * @param ServerCollection $servers
     */
    public function distribute(AssetCollection $assets, ServerCollection $servers)
    {
        if ($servers->count() < 1) {
            return;
        }
        $this->groups = [];
        $this->servers = $servers;
        $this->buildGroups();
        foreach ($assets as $asset) {
            /** @var Asset $asset */
            $asset->setServer($this->groups[$this->getGroupCharacter($asset)]);
        }
    }

    /**
     * @return Server
     */
    private function getNextServer()
    {
        $server = $this->servers->current();
        $this->servers->next();
        if ($this->servers->valid() === false) {
            $this->servers->rewind();
        }
        return $server;
    }

    private function buildGroups()
    {
        $serverCount = $this->servers->count();
        $charCount = strlen($this->characters);
        for ($i = 0; $i < $charCount; $i++) {
            $this->groups[$this->characters[$i]] = $this->getNextServer();
        }
        $this->groups[self::UNKNOWN_GROUP_KEY] = $this->getNextServer();
    }

    /**
     * @param Asset $asset
     * @return string
     */
    private function getGroupCharacter(Asset $asset)
    {
        $hash = md5(sha1($asset->getNormalizedPath()));
        $character = $hash[strlen($hash) - 3];
        if (!str_contains($this->characters, $character)) {
            return self::UNKNOWN_GROUP_KEY;
        }
        return $character;
    }
}
