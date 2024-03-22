<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\MetaMsApplication;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class MetaMsApplicationTest extends UnitTestCase
{
    public function testScrape(): void
    {
        $content = '<meta name="msapplication-TileImage" content="/uploads/images/mstile-144x144.png" />';

        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory
            ->expects($this->exactly(2))
            ->method('createAssetsFromPaths')
            ->with(['/uploads/images/mstile-144x144.png'])
            ->willReturn(new Collection());

        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->exactly(2))
            ->method('getAttributeFromTag')
            ->willReturn([
                'paths' => ['/uploads/images/mstile-144x144.png'],
                'masks' => ['"'],
            ]);

        $scraper = GeneralUtility::makeInstance(MetaMsApplication::class, $attributeExtractor, $assetFactory);
        $scraper->scrape($content);
    }
}
