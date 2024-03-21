<?php

namespace Aoe\Asdis\Content\Replacement;

/**
 * A content replacement map.
 * @see \Aoe\Asdis\Tests\Content\Replacement\MapTest
 */
class Map
{
    private array $sources = [];

    private array $targets = [];

    public function addMapping(string $source, string $target): void
    {
        $this->sources[] = $source;
        $this->targets[] = $target;
    }

    public function getSources(): array
    {
        return $this->sources;
    }

    public function getTargets(): array
    {
        return $this->targets;
    }
}
