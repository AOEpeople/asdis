<?php
namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\MetaMsApplication;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class MetaMsApplicationTest extends UnitTestCase
{
    /**
     * @var MetaMsApplication
     */
    private $scraper;

    /**
     * (non-PHPdoc)
     */
    protected function setUp(): void
    {
        $this->scraper = new MetaMsApplication();
    }

    /**
     * @test
     */
    public function scrape()
    {
        $content = '<meta name="msapplication-TileImage" content="/uploads/images/mstile-144x144.png" />';
        
        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory
            ->expects($this->exactly(2))
            ->method('createAssetsFromPaths')
            ->with(array('/uploads/images/mstile-144x144.png'))
            ->will($this->returnValue(new Collection()));
        
        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->exactly(2))
            ->method('getAttributeFromTag')
            ->will($this->returnValue(
                [
                    'paths' => ['/uploads/images/mstile-144x144.png'],
                    'masks' => ['"'],
                ]
            ));
        
        $this->scraper->injectAssetFactory($assetFactory);
        $this->scraper->injectXmlTagAttributeExtractor($attributeExtractor);
        $this->scraper->scrape($content);
    }
}