<?php

namespace Aoe\Asdis\Tests\Domain\Model\Server;

use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\Domain\Model\Server\Collection;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class CollectionTest extends UnitTestCase
{
    public function testAppend()
    {
        $collection = new Collection();
        $server = new Server();
        $collection->append($server);

        $this->assertSame(1, $collection->count());
    }
}
