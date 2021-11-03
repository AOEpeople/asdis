<?php
namespace Aoe\Asdis\Tests\Content\Replacement;

use Aoe\Asdis\Content\Replacement\Map;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class MapTest extends UnitTestCase
{
    /**
     * @var Map
     */
    private $map;

    /**
     * (non-PHPdoc)
     */
    protected function setUp(): void
    {
        $this->map = new Map();
    }

    /**
     * @test
     */
    public function testAll()
    {
        $source1 = 'AAA';
        $target1 = 'BBB';
        $source2 = 'XXX';
        $target2 = 'YYY';
        
        $this->map->addMapping($source1, $target1);
        $this->map->addMapping($source2, $target2);
        
        $sources = $this->map->getSources();
        $targets = $this->map->getTargets();

        if (false === method_exists($this, 'assertInternalType')) {
            // phpunit 9.x or higher
            $this->assertIsArray($sources);
            $this->assertIsArray($targets);
        } else {
            // phpunit 8.x or lower
            $this->assertInternalType('array', $sources);
            $this->assertInternalType('array', $targets);
        }

        $this->assertEquals(2, sizeof($sources));
        $this->assertEquals(2, sizeof($targets));
        $this->assertEquals($source1, $sources[0]);
        $this->assertEquals($source2, $sources[1]);
        $this->assertEquals($target1, $targets[0]);
        $this->assertEquals($target2, $targets[1]);
    }
}
