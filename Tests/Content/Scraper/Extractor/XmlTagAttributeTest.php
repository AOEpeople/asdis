<?php
namespace Aoe\Asdis\Tests\Content\Scraper\Extractor;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class XmlTagAttributeTest extends UnitTestCase
{
    /**
     * @var XmlTagAttribute
     */
    private $extractor;

    /**
     * (non-PHPdoc)
     */
    protected function setUp()
    {
        $this->extractor = new XmlTagAttribute();
    }

    /**
     * @test
     */
    public function getAttributeFromTag()
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

        $this->assertInternalType('array', $hits);
        $this->assertInternalType('array', $hits['paths']);
        $this->assertInternalType('array', $hits['masks']);
        $this->assertEquals(2, sizeof($hits['paths']));
        $this->assertEquals(2, sizeof($hits['masks']));
        $this->assertEquals($path1, $hits['paths'][0]);
        $this->assertEquals('"', $hits['masks'][0]);
        $this->assertEquals($path2, $hits['paths'][1]);
        $this->assertEquals('"', $hits['masks'][1]);
    }

    /**
     * @test
     */
    public function getAttributeFromTagWithRequiredOtherAttributes()
    {
        $path1 = 'uploads/pics/foo.jpg';
        $path2 = 'typo3temp/tx_foo/bar.gif';
        $content = '<div>
            <input type="image" src="' . $path1 . '" />
            <input src="' . $path2 . '" />
        </div>';

        $hits = $this->extractor->getAttributeFromTag('input', 'src', $content, ['type' => 'image']);

        $this->assertInternalType('array', $hits);
        $this->assertInternalType('array', $hits['paths']);
        $this->assertInternalType('array', $hits['masks']);
        $this->assertEquals(1, sizeof($hits['paths']));
        $this->assertEquals(1, sizeof($hits['masks']));
        $this->assertEquals($path1, $hits['paths'][0]);
        $this->assertEquals('"', $hits['masks'][0]);
    }

    /**
     * @test
     */
    public function getAttributeFromTagWithSeveralSrcAttributes()
    {
        $path1 = 'uploads/pics/foo.jpg';
        $path2 = 'typo3temp/tx_foo/bar.gif';
        $content = '<img src="' . $path1 . '" data-custom-src="' . $path2 . '" style="width: 15px;" />';

        $hits = $this->extractor->getAttributeFromTag('img', 'src', $content);

        $this->assertInternalType('array', $hits);
        $this->assertInternalType('array', $hits['paths']);
        $this->assertInternalType('array', $hits['masks']);
        $this->assertEquals(1, sizeof($hits['paths']));
        $this->assertEquals(1, sizeof($hits['masks']));
        $this->assertEquals($path1, $hits['paths'][0]);
        $this->assertEquals('"', $hits['masks'][0]);
    }

}
