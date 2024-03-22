<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\Script;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ScriptTest extends UnitTestCase
{
    public function testScrape(): void
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
            ->willReturn([
                'paths' => ['typo3temp/js/main.js'],
                'masks' => ['"'],
            ]);

        $scraper = GeneralUtility::makeInstance(Script::class, $attributeExtractor, $assetFactory);
        $scraper->scrape($content);
    }
}
