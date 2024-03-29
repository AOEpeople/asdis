<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\Embed;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class EmbedTest extends UnitTestCase
{
    public function testScrape(): void
    {
        $content = '<embed src="typo3temp/flash.swf" />';

        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory->expects($this->once())
            ->method('createAssetsFromPaths')
            ->with(['typo3temp/flash.swf']);

        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->once())
            ->method('getAttributeFromTag')
            ->with('embed', 'src', $content)
            ->willReturn([
                'paths' => ['typo3temp/flash.swf'],
                'masks' => ['"'],
            ]);

        $scraper = GeneralUtility::makeInstance(Embed::class, $attributeExtractor, $assetFactory);
        $scraper->scrape($content);
    }
}
