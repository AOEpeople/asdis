<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\FontFile;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class FontFileTest extends UnitTestCase
{
    public function testScrape(): void
    {
        $content = '<link rel="preload" href="/typo3temp/foo.woff2" as="font" type="font/woff2" />';

        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory
            ->expects($this->exactly(6))
            ->method('createAssetsFromPaths')
            ->with(['typo3temp/foo.woff2'])
            ->willReturn(new Collection());

        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->exactly(6))
            ->method('getAttributeFromTag')
            ->willReturn([
                'paths' => ['typo3temp/foo.woff2'],
                'masks' => ['"'],
            ]);

        $scraper = GeneralUtility::makeInstance(FontFile::class, $attributeExtractor, $assetFactory);
        $scraper->scrape($content);
    }
}
