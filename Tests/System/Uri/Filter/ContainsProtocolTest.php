<?php

namespace Aoe\Asdis\Tests\System\Uri\Filter;

use Aoe\Asdis\System\Uri\Filter\ContainsProtocol;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ContainsProtocolTest extends UnitTestCase
{
    private ContainsProtocol $filter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->filter = new ContainsProtocol();
    }

    public function testFilter(): void
    {
        $paths = [
            'http://typo3temp/pics/foo.gif',
            'https://typo3temp/pics/foo.gif',
            '###HTTP_S###typo3temp/pics/foo.gif',
            'typo3temp/pics/foo.jpg',
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
        $this->assertSame($paths[3], $filteredPaths[0]);
    }
}
