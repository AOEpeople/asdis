<?php

namespace Aoe\Asdis\Tests\System\Uri\Filter;

use Aoe\Asdis\System\Uri\Filter\TooShort;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class TooShortTest extends UnitTestCase
{
    private TooShort $filter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->filter = new TooShort();
    }

    public function testFilter(): void
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

        $this->assertCount(1, $filteredPaths);
        $this->assertSame($paths[2], $filteredPaths[0]);
    }
}
