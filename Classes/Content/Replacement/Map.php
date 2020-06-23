<?php
namespace Aoe\Asdis\Content\Replacement;

/**
 * A content replacement map.
 */
class Map
{
    /**
     * @var array
     */
    private $sources = [];

    /**
     * @var array
     */
    private $targets = [];

    /**
     * @param string $source
     * @param string $target
     */
    public function addMapping($source, $target)
    {
        $this->sources[] = $source;
        $this->targets[] = $target;
    }

    /**
     * @return array
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * @return array
     */
    public function getTargets()
    {
        return $this->targets;
    }
}