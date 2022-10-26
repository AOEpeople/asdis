<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Html\Srcset;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class SrcsetTest extends UnitTestCase
{
    private Srcset $srcset;

    protected function setUp(): void
    {
        $this->srcset = new Srcset();
    }

    /**
     * Tests Tx_Asdis_Content_Scraper_Css_Url->scrape()
     */
    public function testScrapePictureSource()
    {
        $assetFactory = $this->getMockBuilder(Factory::class)
            ->setMethods(['createAssetsFromPaths'])
            ->disableOriginalConstructor()
            ->getMock();

        $assetFactory->expects($this->once())
            ->method('createAssetsFromPaths')
            ->with([
            '//my-domain.local/fileadmin/a.webp',
            '//my-domain.local/fileadmin/b.webp',
            '//my-domain.local/fileadmin/c.png',
            '//my-domain.local/fileadmin/d.png',
        ]);

        $this->srcset->injectAssetFactory($assetFactory);
        $this->srcset->scrape(
            '<picture>
                <source media="(min-width: 250px)" srcset="//my-domain.local/fileadmin/a.webp, //my-domain.local/fileadmin/b.webp 2x" type="image/webp">
                <source media="(min-width: 250px)" srcset="//my-domain.local/fileadmin/c.png, //my-domain.local/fileadmin/d.png 2x">
                <img src="//my-domain.local/fileadmin/e.png" width="464" height="261">
            </picture>'
        );
    }

    /**
     * Tests Tx_Asdis_Content_Scraper_Css_Url->scrape()
     */
    public function testScrapeLinkImagesrcset()
    {
        $assetFactory = $this->getMockBuilder(Factory::class)
            ->setMethods(['createAssetsFromPaths'])
            ->disableOriginalConstructor()
            ->getMock();

        $assetFactory->expects($this->once())
            ->method('createAssetsFromPaths')
            ->with([
            '//my-domain.local/fileadmin/a.webp',
            '//my-domain.local/fileadmin/b.webp',
            '//my-domain.local/fileadmin/c.webp',
            '//my-domain.local/fileadmin/d.webp',
            '//my-domain.local/fileadmin/e.webp',
        ]);

        $this->srcset->injectAssetFactory($assetFactory);
        $this->srcset->scrape(
            '<link rel="preload" as="image" href="//my-domain.local/fileadmin/a.webp" type="image/webp" imagesizes="1100w" imagesrcset="//my-domain.local/fileadmin/a.webp 1100w, //my-domain.local/fileadmin/b.webp 870w, //my-domain.local/fileadmin/c.webp 991w, //my-domain.local/fileadmin/d.webp 767w, //my-domain.local/fileadmin/e.webp 576w">'
        );
    }
}
