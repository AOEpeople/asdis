<?php

namespace Aoe\Asdis\Domain\Model\DistributionAlgorithm;

use Aoe\Asdis\Domain\Model\Asset;
use Aoe\Asdis\Domain\Model\Asset\Collection as AssetCollection;
use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\Domain\Model\Server\Collection as ServerCollection;

/**
 * A distribution algorithm which is based on the assets hashed filenames.
 * @see \Aoe\Asdis\Tests\Domain\Model\DistributionAlgorithm\HashBasedGroupsTest
 */
class HashBasedGroups implements DistributionAlgorithmInterface
{
    /**
     * @var string
     */
    public const UNKNOWN_GROUP_KEY = 'unknown';

    private ?ServerCollection $servers = null;

    private string $characters = '0123456789abcdef';

    private array $groups = [];

    /**
     * Distributes the given assets to the given servers.
     */
    public function distribute(AssetCollection $assets, ServerCollection $servers): void
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

    private function getNextServer(): Server
    {
        $server = $this->servers->current();
        $this->servers->next();
        if (!$this->servers->valid()) {
            $this->servers->rewind();
        }

        return $server;
    }

    private function buildGroups(): void
    {
        $charCount = strlen($this->characters);
        for ($i = 0; $i < $charCount; $i++) {
            $this->groups[$this->characters[$i]] = $this->getNextServer();
        }

        $this->groups[self::UNKNOWN_GROUP_KEY] = $this->getNextServer();
    }

    private function getGroupCharacter(Asset $asset): string
    {
        $hash = md5(sha1($asset->getNormalizedPath()));
        $character = $hash[strlen($hash) - 3];
        if (!str_contains($this->characters, $character)) {
            return self::UNKNOWN_GROUP_KEY;
        }

        return $character;
    }
}
