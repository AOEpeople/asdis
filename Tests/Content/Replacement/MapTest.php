<?php

namespace Aoe\Asdis\Tests\Content\Replacement;

use Aoe\Asdis\Content\Replacement\Map;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class MapTest extends UnitTestCase
{
    private Map $map;

    protected function setUp(): void
    {
        $this->map = new Map();
    }

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

        if (!method_exists($this, 'assertInternalType')) {
            // phpunit 9.x or higher
            $this->assertIsArray($sources);
            $this->assertIsArray($targets);
        } else {
            // phpunit 8.x or lower
            $this->assertInternalType('array', $sources);
            $this->assertInternalType('array', $targets);
        }

        $this->assertSame(2, count($sources));
        $this->assertSame(2, count($targets));
        $this->assertSame($source1, $sources[0]);
        $this->assertSame($source2, $sources[1]);
        $this->assertSame($target1, $targets[0]);
        $this->assertSame($target2, $targets[1]);
    }
}
