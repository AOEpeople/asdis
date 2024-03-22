<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\CssFile;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class CssFileTest extends UnitTestCase
{
    public function testScrape(): void
    {
        $content = '<link href="typo3temp/foo.css" rel="stylesheet" />';

        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory
            ->expects($this->exactly(2))
            ->method('createAssetsFromPaths')
            ->with(['typo3temp/foo.css'])
            ->willReturn(new Collection());

        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->exactly(2))
            ->method('getAttributeFromTag')
            ->willReturn([
                'paths' => ['typo3temp/foo.css'],
                'masks' => ['"'],
            ]);

        $scraper = GeneralUtility::makeInstance(CssFile::class, $attributeExtractor, $assetFactory);
        $scraper->scrape($content);
    }
}
