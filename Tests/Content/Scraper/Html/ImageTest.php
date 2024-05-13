<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\Image;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ImageTest extends UnitTestCase
{
    public function testScrape(): void
    {
        $content = '<image src="uploads/images/foo.gif" />';

        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory
            ->expects($this->exactly(3))
            ->method('createAssetsFromPaths')
            ->with(['uploads/tx_templavoila/example.gif'])
            ->willReturn(new Collection());

        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->exactly(3))
            ->method('getAttributeFromTag')
            ->willReturn([
                'paths' => ['uploads/tx_templavoila/example.gif'],
                'masks' => ['"'],
            ]);

        $scraper = GeneralUtility::makeInstance(Image::class, $attributeExtractor, $assetFactory);
        $scraper->scrape($content);
    }
}
