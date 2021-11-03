<?php
namespace Aoe\Asdis\Tests\System\Uri\Filter;

use Aoe\Asdis\System\Uri\Filter\WildcardProtocol;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class WildcardProtocolTest extends UnitTestCase
{
    /**
     * @var WildcardProtocol
     */
    private $filter;

    /**
     * (non-PHPdoc)
     */
    protected function setUp(): void
    {
        $this->filter = new WildcardProtocol();
    }

    /**
     * @test
     */
    public function filter() {
        $paths = [
            '//typo3temp/pics/foo.gif',
            'https://typo3temp/pics/foo.gif'
        ];
        $filteredPaths = $this->filter->filter($paths);
        if (false === method_exists($this, 'assertInternalType')) {
            // phpunit 9.x or higher
            $this->assertIsArray($filteredPaths);
        } else {
            // phpunit 8.x or lower
            $this->assertInternalType('array', $filteredPaths);
        }
        $this->assertEquals(1, sizeof($filteredPaths));
        $this->assertEquals($paths[1], $filteredPaths[0]);
    }
}
