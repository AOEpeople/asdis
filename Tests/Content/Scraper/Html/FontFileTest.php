<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\FontFile;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class FontFileTest extends UnitTestCase
{
    /**
     * @var FontFile
     */
    private $scraper;

    /**
     * (non-PHPdoc)
     */
    protected function setUp(): void
    {
        $this->scraper = new CssFile();
    }

    /**
     * @test
     */
    public function scrape()
    {
        $content = '<link rel="preload" href="/typo3temp/foo.woff2" as="font" type="font/woff2" />';
        
        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory
            ->expects($this->exactly(2))
            ->method('createAssetsFromPaths')
            ->with(array('typo3temp/foo.woff2'))
            ->will($this->returnValue(new Collection()));
        
        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->exactly(2))
            ->method('getAttributeFromTag')
            ->will($this->returnValue(
                [
                    'paths' => ['typo3temp/foo.woff2'],
                    'masks' => ['"'],
                ]
            ));
        
        $this->scraper->injectAssetFactory($assetFactory);
        $this->scraper->injectXmlTagAttributeExtractor($attributeExtractor);
        $this->scraper->scrape($content);
    }
}

