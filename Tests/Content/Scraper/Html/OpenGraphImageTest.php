<?php
namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\OpenGraphImage;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class OpenGraphImageTest extends UnitTestCase
{
    /**
     * @var OpenGraphImage
     */
    private $scraper;

    /**
     * (non-PHPdoc)
     */
    protected function setUp()
    {
        $this->scraper = new OpenGraphImage();
    }

    /**
     * @test
     */
    public function scrape()
    {
        $content = '<meta property="og:image" content="uploads/images/foo.gif" />';
        
        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory->expects($this->once())->method('createAssetsFromPaths')->with(['uploads/images/foo.gif']);
        
        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->once())
            ->method('getAttributeFromTag')
            ->with('meta', 'content', $content, ['property' => 'og:image'])
            ->will($this->returnValue(
                [
                    'paths' => ['uploads/images/foo.gif'],
                    'masks' => ['"'],
                ]
            ));
        
        $this->scraper->injectAssetFactory($assetFactory);
        $this->scraper->injectXmlTagAttributeExtractor($attributeExtractor);
        $this->scraper->scrape($content);
    }
}

