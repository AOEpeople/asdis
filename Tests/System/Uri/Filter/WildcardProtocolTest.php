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
    protected function setUp()
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
        $this->assertInternalType('array', $filteredPaths);
        $this->assertEquals(1, sizeof($filteredPaths));
        $this->assertEquals($paths[1], $filteredPaths[0]);
    }
}

