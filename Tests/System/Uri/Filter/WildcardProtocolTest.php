<?php

namespace Aoe\Asdis\Tests\System\Uri\Filter;

use Aoe\Asdis\System\Uri\Filter\WildcardProtocol;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class WildcardProtocolTest extends UnitTestCase
{
    private WildcardProtocol $filter;

    protected function setUp(): void
    {
        $this->filter = new WildcardProtocol();
    }

    public function testFilter()
    {
        $paths = [
            '//typo3temp/pics/foo.gif',
            'https://typo3temp/pics/foo.gif',
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
        $this->assertSame($paths[1], $filteredPaths[0]);
    }
}
