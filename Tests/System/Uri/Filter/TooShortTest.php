<?php

namespace Aoe\Asdis\Tests\System\Uri\Filter;

use Aoe\Asdis\System\Uri\Filter\TooShort;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class TooShortTest extends UnitTestCase
{
    private TooShort $filter;

    protected function setUp(): void
    {
        $this->filter = new TooShort();
    }

    public function testFilter()
    {
        $paths = [
            '',
            'test',
            'typo3temp/pics/foo.gif',
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
        $this->assertSame($paths[2], $filteredPaths[0]);
    }
}
