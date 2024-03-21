<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\AppleTouchIcon;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class AppleTouchIconTest extends UnitTestCase
{
    public function testScrape(): void
    {
        $content = '<link href="uploads/images/foo.gif" rel="apple-touch-icon-precomposed" /><link href="foo/bar/baz.gif" />';

        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory
            ->expects($this->exactly(2))
            ->method('createAssetsFromPaths')
            ->with(['uploads/images/foo.gif'])
            ->willReturn(new Collection());

        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->exactly(2))
            ->method('getAttributeFromTag')
            ->willReturn([
                'paths' => ['uploads/images/foo.gif'],
                'masks' => ['"'],
            ]);

        $scraper = GeneralUtility::makeInstance(AppleTouchIcon::class, $attributeExtractor, $assetFactory);
        $scraper->scrape($content);
    }
}
