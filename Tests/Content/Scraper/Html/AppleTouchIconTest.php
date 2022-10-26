<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\AppleTouchIcon;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class AppleTouchIconTest extends UnitTestCase
{
    private AppleTouchIcon $scraper;

    protected function setUp(): void
    {
        $this->scraper = new AppleTouchIcon();
    }

    public function testScrape()
    {
        $content = '<link href="uploads/images/foo.gif" rel="apple-touch-icon-precomposed" /><link href="foo/bar/baz.gif" />';

        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory
            ->expects($this->exactly(2))
            ->method('createAssetsFromPaths')
            ->with(['uploads/images/foo.gif'])
            ->will($this->returnValue(new Collection()));

        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->exactly(2))
            ->method('getAttributeFromTag')
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
