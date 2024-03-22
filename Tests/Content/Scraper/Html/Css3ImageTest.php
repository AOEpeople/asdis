<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Content\Scraper\Html\Css3Image;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class Css3ImageTest extends UnitTestCase
{
    private Css3Image $css3Image;

    protected function setUp(): void
    {
        $xmlTagAttributeExtractor = new XmlTagAttribute();
        $factory = new Factory();

        $this->css3Image = GeneralUtility::makeInstance(Css3Image::class, $xmlTagAttributeExtractor, $factory);
    }

    /**
     * Tests Tx_Asdis_Content_Scraper_Css_Url->scrape()
     */
    public function testScrape(): void
    {
        $assetFactory = $this->getMockBuilder(Factory::class)
            ->onlyMethods(['createAssetsFromPaths'])
            ->disableOriginalConstructor()
            ->getMock();

        $assetFactory->expects($this->once())
            ->method('createAssetsFromPaths')
            ->with([
                '//my-domain.local/fileadmin/550px.jpg',
                '//my-domain.local/fileadmin/250px.jpg',
                '//my-domain.local/fileadmin/250px.jpg',
                '//my-domain.local/fileadmin/1000px.jpg',
                '//my-domain.local/fileadmin/1500px.jpg',
                '//my-domain.local/fileadmin/1500px.jpg',
            ]);

        $this->css3Image->injectAssetFactory($assetFactory);

        $this->css3Image->scrape(
            '<div data-src-desktop="//my-domain.local/fileadmin/550px.jpg"></div>' .
            '<div data-src-phone="//my-domain.local/fileadmin/250px.jpg"></div>' .
            '<div data-src-phone-highres="//my-domain.local/fileadmin/250px.jpg"></div>' .
            '<div data-src-desktop="//my-domain.local/fileadmin/1000px.jpg" data-src-desktop-highres="//my-domain.local/fileadmin/1500px.jpg"></div>' .
            '<img src="//my-domain.local/fileadmin/1000px.jpg" data-src-desktop-highres="//my-domain.local/fileadmin/1500px.jpg" />'
        );
    }
}
