<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\OpenGraphImage;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class OpenGraphImageTest extends UnitTestCase
{
    public function testScrape(): void
    {
        $content = '<meta property="og:image" content="uploads/images/foo.gif" />';

        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory->expects($this->once())
            ->method('createAssetsFromPaths')
            ->with(['uploads/images/foo.gif']);

        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->once())
            ->method('getAttributeFromTag')
            ->with(
                'meta',
                'content',
                $content,
                [
                    'property' => 'og:image',
                ]
            )
            ->willReturn([
                'paths' => ['uploads/images/foo.gif'],
                'masks' => ['"'],
            ]);

        $scraper = GeneralUtility::makeInstance(OpenGraphImage::class, $attributeExtractor, $assetFactory);
        $scraper->scrape($content);
    }
}
