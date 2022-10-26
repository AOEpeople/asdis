<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\Image;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class ImageTest extends UnitTestCase
{
    private Image $imageScraper;

    protected function setUp(): void
    {
        $this->imageScraper = new Image();
    }

    public function testScrape()
    {
        $content = '<image src="uploads/images/foo.gif" />';

        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory
            ->expects($this->exactly(2))
            ->method('createAssetsFromPaths')
            ->with(['uploads/tx_templavoila/example.gif'])
            ->will($this->returnValue(new Collection()));

        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->exactly(2))
            ->method('getAttributeFromTag')
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
