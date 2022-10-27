<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\MetaMsApplication;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class MetaMsApplicationTest extends UnitTestCase
{
    public function testScrape()
    {
        $content = '<meta name="msapplication-TileImage" content="/uploads/images/mstile-144x144.png" />';

        $assetFactory = $this->getMockBuilder(Factory::class)->getMock();
        $assetFactory
            ->expects($this->exactly(2))
            ->method('createAssetsFromPaths')
            ->with(['/uploads/images/mstile-144x144.png'])
            ->will($this->returnValue(new Collection()));

        $attributeExtractor = $this->getMockBuilder(XmlTagAttribute::class)->getMock();
        $attributeExtractor
            ->expects($this->exactly(2))
            ->method('getAttributeFromTag')
            ->will($this->returnValue(
                [
                    'paths' => ['/uploads/images/mstile-144x144.png'],
                    'masks' => ['"'],
                ]
            ));

        $scraper = GeneralUtility::makeInstance(MetaMsApplication::class, $attributeExtractor, $assetFactory);
        $scraper->scrape($content);
    }
}
