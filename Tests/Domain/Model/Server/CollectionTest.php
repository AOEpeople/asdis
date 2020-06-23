<?php
namespace Aoe\Asdis\Tests\Domain\Model\Server;

use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\Domain\Model\Server\Collection;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class CollectionTest extends UnitTestCase
{
    /**
     * @test
     */
    public function append()
    {
        $collection = new Collection();
        $server = new Server();
        $collection->append($server);
        
        $this->assertEquals(1, $collection->count());
    }
}

