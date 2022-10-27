<?php

namespace Aoe\Asdis\Tests\System\Uri;

use Aoe\Asdis\System\Uri\Normalizer;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class NormalizerTest extends UnitTestCase
{
    private Normalizer $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new Normalizer();
    }

    public function testNormalizePath()
    {
        $this->assertSame('typo3temp/pics/foo.gif', $this->normalizer->normalizePath('/typo3temp/pics/foo.gif'));
        $this->assertSame('typo3temp/pics/bar.gif', $this->normalizer->normalizePath('typo3temp/pics/bar.gif'));
        $this->assertSame('typo3temp/pics/foo.png', $this->normalizer->normalizePath('//example.com/typo3temp/pics/foo.png'));
        $this->assertSame('typo3temp/pics/bar.jpg', $this->normalizer->normalizePath('//www.example.com/typo3temp/pics/bar.jpg'));
        $this->assertSame('typo3temp/pics/foo.png', $this->normalizer->normalizePath('http://example.com/typo3temp/pics/foo.png'));
        $this->assertSame('typo3temp/pics/bar.jpg', $this->normalizer->normalizePath('http://www.example.com/typo3temp/pics/bar.jpg'));
    }
}
