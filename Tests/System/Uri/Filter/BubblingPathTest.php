<?php
namespace Aoe\Asdis\Tests\System\Uri\Filter;

use Aoe\Asdis\System\Uri\Filter\BubblingPath;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class BubblingPathTest extends UnitTestCase
{
    /**
     * @var BubblingPath
     */
    private $filter;

    /**
     * (non-PHPdoc)
     */
    protected function setUp(): void
    {
        $this->filter = new BubblingPath();
    }

    /**
     * @test
     */
    public function filter() 
    {
        $paths = [
            'typo3temp/pics/foo.gif',
            'typo3temp/../pics/foo.jpg'
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
        $this->assertEquals($paths[0], $filteredPaths[0]);
    }
}
