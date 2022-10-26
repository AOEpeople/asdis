<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\Script;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class ScriptTest extends UnitTestCase
{
    private Script $scraper;

    protected function setUp(): void
    {
        $this->scraper = new Script();
    }

    public function testScrape()
    {
        $content = '<script type="text/javascript" src="typo3temp/js/main.js" />';

        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory->expects($this->once())
            ->method('createAssetsFromPaths')
            ->with(['typo3temp/js/main.js']);

        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->once())
            ->method('getAttributeFromTag')
            ->with('script', 'src', $content)
            ->will($this->returnValue(
                [
                    'paths' => ['typo3temp/js/main.js'],
                    'masks' => ['"'],
                ]
            ));

        $this->scraper->injectAssetFactory($assetFactory);
        $this->scraper->injectXmlTagAttributeExtractor($attributeExtractor);
        $this->scraper->scrape($content);
    }
}
