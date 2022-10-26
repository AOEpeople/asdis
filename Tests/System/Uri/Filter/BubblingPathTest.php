<?php

namespace Aoe\Asdis\Tests\System\Uri\Filter;

use Aoe\Asdis\System\Uri\Filter\BubblingPath;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class BubblingPathTest extends UnitTestCase
{
    private BubblingPath $filter;

    protected function setUp(): void
    {
        $this->filter = new BubblingPath();
    }

    public function testFilter()
    {
        $paths = [
            'typo3temp/pics/foo.gif',
            'typo3temp/../pics/foo.jpg',
        ];
        $filteredPaths = $this->filter->filter($paths);

        if (!method_exists($this, 'assertInternalType')) {
            // phpunit 9.x or higher
            $this->assertIsArray($filteredPaths);
        } else {
            // phpunit 8.x or lower
            $this->assertInternalType('array', $filteredPaths);
        }
        $this->assertSame(1, count($filteredPaths));
        $this->assertSame($paths[0], $filteredPaths[0]);
    }
}
