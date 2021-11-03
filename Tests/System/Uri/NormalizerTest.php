<?php
namespace Aoe\Asdis\Tests\System\Uri;

use Aoe\Asdis\System\Uri\Normalizer;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class NormalizerTest extends UnitTestCase
{
    /**
     * @var Normalizer
     */
    private $normalizer;

    /**
     * (non-PHPdoc)
     */
    protected function setUp(): void
    {
        $this->normalizer = new Normalizer();
    }

    /**
     * @test
     */
    public function normalizePath() 
    {
        $this->assertEquals('typo3temp/pics/foo.gif', $this->normalizer->normalizePath('/typo3temp/pics/foo.gif'));
        $this->assertEquals('typo3temp/pics/bar.gif', $this->normalizer->normalizePath('typo3temp/pics/bar.gif'));
        $this->assertEquals('typo3temp/pics/foo.png', $this->normalizer->normalizePath('//example.com/typo3temp/pics/foo.png'));
        $this->assertEquals('typo3temp/pics/bar.jpg', $this->normalizer->normalizePath('//www.example.com/typo3temp/pics/bar.jpg'));
        $this->assertEquals('typo3temp/pics/foo.png', $this->normalizer->normalizePath('http://example.com/typo3temp/pics/foo.png'));
        $this->assertEquals('typo3temp/pics/bar.jpg', $this->normalizer->normalizePath('http://www.example.com/typo3temp/pics/bar.jpg'));
    }
}

