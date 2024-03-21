<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\Favicon;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class FaviconTest extends UnitTestCase
{
    public function testScrape(): void
    {
        $content = '<link href="typo3temp/favicon.ico" rel="icon" />';

        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory
            ->expects($this->exactly(5))
            ->method('createAssetsFromPaths')
            ->with(['typo3temp/favicon.ico'])
            ->willReturn(new Collection());

        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->exactly(5))
            ->method('getAttributeFromTag')
            ->willReturn([
                'paths' => ['typo3temp/favicon.ico'],
                'masks' => ['"'],
            ]);

        $scraper = GeneralUtility::makeInstance(Favicon::class, $attributeExtractor, $assetFactory);
        $scraper->scrape($content);
    }
}
