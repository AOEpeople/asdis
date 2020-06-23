<?php
namespace Aoe\Asdis\Tests\System\Uri\Filter;

use Aoe\Asdis\System\Uri\Filter\ContainsProtocol;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class ContainsProtocolTest extends UnitTestCase
{
    /**
     * @var ContainsProtocol
     */
    private $filter;

    /**
     * (non-PHPdoc)
     */
    protected function setUp()
    {
        $this->filter = new ContainsProtocol();
    }

    /**
     * @test
     */
    public function filter()
    {
        $paths = [
            'http://typo3temp/pics/foo.gif',
            'https://typo3temp/pics/foo.gif',
            '###HTTP_S###typo3temp/pics/foo.gif',
            'typo3temp/pics/foo.jpg'
        ];
        $filteredPaths = $this->filter->filter($paths);
        $this->assertInternalType('array', $filteredPaths);
        $this->assertEquals(1, sizeof($filteredPaths));
        $this->assertEquals($paths[3], $filteredPaths[0]);
    }
}

