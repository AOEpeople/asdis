<?php
namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\CssFile;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class CssFileTest extends UnitTestCase
{
    /**
     * @var CssFile
     */
    private $scraper;

    /**
     * (non-PHPdoc)
     */
    protected function setUp()
    {
        $this->scraper = new CssFile();
    }

    /**
     * @test
     */
    public function scrape()
    {
        $content = '<link href="typo3temp/foo.css" rel="stylesheet" />';
        
        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory
            ->expects($this->exactly(2))
            ->method('createAssetsFromPaths')
            ->with(array('typo3temp/foo.css'))
            ->will($this->returnValue(new Collection()));
        
        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->exactly(2))
            ->method('getAttributeFromTag')
            ->will($this->returnValue(
                [
                    'paths' => ['typo3temp/foo.css'],
                    'masks' => ['"'],
                ]
            ));
        
        $this->scraper->injectAssetFactory($assetFactory);
        $this->scraper->injectXmlTagAttributeExtractor($attributeExtractor);
        $this->scraper->scrape($content);
    }
}

