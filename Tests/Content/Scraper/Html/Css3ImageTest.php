<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Html\Css3Image;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class Css3ImageTest extends UnitTestCase
{
    private Css3Image $css3Image;

    protected function setUp(): void
    {
        $this->css3Image = new Css3Image();
    }

    /**
     * Tests Tx_Asdis_Content_Scraper_Css_Url->scrape()
     */
    public function testScrape()
    {
        $assetFactory = $this->getMockBuilder(Factory::class)
            ->setMethods(['createAssetsFromPaths'])
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
