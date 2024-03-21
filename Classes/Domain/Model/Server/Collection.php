<?php

namespace Aoe\Asdis\Domain\Model\Server;

use Aoe\Asdis\Domain\Model\Server;
use ArrayIterator;

/**
 * Collection which contains server objects.
 * @see \Aoe\Asdis\Tests\Domain\Model\Server\CollectionTest
 */
class Collection extends ArrayIterator
{
    /**
     * Needs to be called due to an extbase bug.
     * Hides optional parameters of parent constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Server $server
     */
    public function append($server): void
    {
        parent::append($server);
    }
}
