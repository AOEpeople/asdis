<?php
namespace Aoe\Asdis\Tests\System\Uri\Filter;

use Aoe\Asdis\System\Uri\Filter\TooShort;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class TooShortTest extends UnitTestCase
{
    /**
     * @var TooShort
     */
    private $filter;

    /**
     * (non-PHPdoc)
     */
    protected function setUp()
    {
        $this->filter = new TooShort();
    }

    /**
     * @test
     */
    public function filter()
    {
        $paths = [
            '',
            'test',
            'typo3temp/pics/foo.gif'
        ];
        $filteredPaths = $this->filter->filter($paths);
        $this->assertInternalType('array', $filteredPaths);
        $this->assertEquals(1, sizeof($filteredPaths));
        $this->assertEquals($paths[2], $filteredPaths[0]);
    }
}

