<?php
namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\Embed;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class EmbedTest extends UnitTestCase
{
    /**
     * @var Embed
     */
    private $scraper;

    /**
     * (non-PHPdoc)
     */
    protected function setUp()
    {
        $this->scraper = new Embed();
    }

    /**
     * @test
     */
    public function scrape()
    {
        $content = '<embed src="typo3temp/flash.swf" />';
        
        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory->expects($this->once())->method('createAssetsFromPaths')->with(['typo3temp/flash.swf']);
        
        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->once())
            ->method('getAttributeFromTag')
            ->with('embed', 'src', $content)
            ->will($this->returnValue(
                [
                    'paths' => ['typo3temp/flash.swf'],
                    'masks' => ['"']
                ]
            ));
        
        $this->scraper->injectAssetFactory($assetFactory);
        $this->scraper->injectXmlTagAttributeExtractor($attributeExtractor);
        $this->scraper->scrape($content);
    }
}

