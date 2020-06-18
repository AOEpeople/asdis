<?php
namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\Image;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class ImageTest extends UnitTestCase
{
    /**
     * @var Image
     */
    private $imageScraper;

    /**
     * (non-PHPdoc)
     */
    protected function setUp()
    {
        $this->imageScraper = new Image();
    }

    /**
     * @test
     */
    public function scrape()
    {
        $content = '<image src="uploads/images/foo.gif" />';
        
        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory
            ->expects($this->once())
            ->method('createAssetsFromPaths')
            ->with(['uploads/tx_templavoila/example.gif']);
        
        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->once())
            ->method('getAttributeFromTag')
            ->with('img', 'src', $content)
            ->will($this->returnValue(
                [
                    'paths' => ['uploads/tx_templavoila/example.gif'],
                    'masks' => ['"'],
                ]
            ));
        
        $this->imageScraper->injectAssetFactory($assetFactory);
        $this->imageScraper->injectXmlTagAttributeExtractor($attributeExtractor);
        $this->imageScraper->scrape($content);
    }
}

