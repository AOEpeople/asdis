<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Extractor;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class XmlTagAttributeTest extends UnitTestCase
{
    private XmlTagAttribute $extractor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extractor = new XmlTagAttribute();
    }

    public function testGetAttributeFromTag(): void
    {
        $path1 = 'uploads/pics/foo.jpg';
        $path2 = 'typo3temp/tx_foo/bar.gif';
        $content = '<div class="foo">
            <img src="' . $path1 . '" style="width: 15px;" />
            <p>
                <img src="' . $path2 . '" />
            </p>
        </div>';

        $hits = $this->extractor->getAttributeFromTag('img', 'src', $content);

        if (!method_exists($this, 'assertInternalType')) {
            // phpunit 9.x or higher
            $this->assertIsArray($hits);
            $this->assertIsArray($hits['paths']);
            $this->assertIsArray($hits['masks']);
        } else {
            // phpunit 8.x or lower
            $this->assertInternalType('array', $hits);
            $this->assertInternalType('array', $hits['paths']);
            $this->assertInternalType('array', $hits['masks']);
        }

        $this->assertCount(2, $hits['paths']);
        $this->assertCount(2, $hits['masks']);
        $this->assertSame($path1, $hits['paths'][0]);
        $this->assertSame('"', $hits['masks'][0]);
        $this->assertSame($path2, $hits['paths'][1]);
        $this->assertSame('"', $hits['masks'][1]);
    }

    public function testGetAttributeFromTagWithRequiredOtherAttributes(): void
    {
        $path1 = 'uploads/pics/foo.jpg';
        $path2 = 'typo3temp/tx_foo/bar.gif';
        $content = '<div>
            <input type="image" src="' . $path1 . '" />
            <input src="' . $path2 . '" />
        </div>';

        $hits = $this->extractor->getAttributeFromTag(
            'input',
            'src',
            $content,
            [
                'type' => 'image',
            ]
        );

        if (!method_exists($this, 'assertInternalType')) {
            // phpunit 9.x or higher
            $this->assertIsArray($hits);
            $this->assertIsArray($hits['paths']);
            $this->assertIsArray($hits['masks']);
        } else {
            // phpunit 8.x or lower
            $this->assertInternalType('array', $hits);
            $this->assertInternalType('array', $hits['paths']);
            $this->assertInternalType('array', $hits['masks']);
        }

        $this->assertCount(1, $hits['paths']);
        $this->assertCount(1, $hits['masks']);
        $this->assertSame($path1, $hits['paths'][0]);
        $this->assertSame('"', $hits['masks'][0]);
    }

    public function testGetAttributeFromTagWithSeveralSrcAttributes(): void
    {
        $path1 = 'uploads/pics/foo.jpg';
        $path2 = 'typo3temp/tx_foo/bar.gif';
        $content = '<img src="' . $path1 . '" data-custom-src="' . $path2 . '" style="width: 15px;" />';

        $hits = $this->extractor->getAttributeFromTag('img', 'src', $content);

        if (!method_exists($this, 'assertInternalType')) {
            // phpunit 9.x or higher
            $this->assertIsArray($hits);
            $this->assertIsArray($hits['paths']);
            $this->assertIsArray($hits['masks']);
        } else {
            // phpunit 8.x or lower
            $this->assertInternalType('array', $hits);
            $this->assertInternalType('array', $hits['paths']);
            $this->assertInternalType('array', $hits['masks']);
        }

        $this->assertCount(1, $hits['paths']);
        $this->assertCount(1, $hits['masks']);
        $this->assertSame($path1, $hits['paths'][0]);
        $this->assertSame('"', $hits['masks'][0]);
    }
}
