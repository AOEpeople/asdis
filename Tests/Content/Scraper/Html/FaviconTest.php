<?php
namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\Favicon;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class FaviconTest extends UnitTestCase
{
    /**
     * @var Favicon
     */
    private $scraper;

    /**
     * (non-PHPdoc)
     */
    protected function setUp()
    {
        $this->scraper = new Favicon();
    }

    /**
     * @test
     */
    public function scrape()
    {
        $content = '<link href="typo3temp/favicon.ico" rel="icon" />';
        
        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory
            ->expects($this->exactly(5))
            ->method('createAssetsFromPaths')
            ->with(array('typo3temp/favicon.ico'))
            ->will($this->returnValue(new Collection()));
        
        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->exactly(5))
            ->method('getAttributeFromTag')
            ->will($this->returnValue(
                [
                    'paths' => ['typo3temp/favicon.ico'],
                    'masks' => ['"']
                ]
            ));
        
        $this->scraper->injectAssetFactory($assetFactory);
        $this->scraper->injectXmlTagAttributeExtractor($attributeExtractor);
        $this->scraper->scrape($content);
    }
}

