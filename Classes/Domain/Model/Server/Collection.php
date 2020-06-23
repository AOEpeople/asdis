<?php
namespace Aoe\Asdis\Domain\Model\Server;

/**
 * Collection which contains server objects.
 */
class Collection extends \ArrayIterator
{
    /**
     * Needs to be called due to an extbase bug.
     * Hides optional parameters of parent constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param \Aoe\Asdis\Domain\Model\Server $server
     */
    public function append($server) {
        parent::append($server);
    }
}