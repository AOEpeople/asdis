<?php
namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Html\Srcset;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class SrcsetTest extends UnitTestCase
{
    /**
     * @var Srcset
     */
    private $srcset;

    /**
     * (non-PHPdoc)
     */
    protected function setUp()
    {
        $this->srcset = new Srcset();
    }

    /**
     * Tests Tx_Asdis_Content_Scraper_Css_Url->scrape()
     * @test
     */
    public function scrape()
    {
        $assetFactory = $this->getMockBuilder(Factory::class)
            ->setMethods(array('createAssetsFromPaths'))
            ->disableOriginalConstructor()
            ->getMock();

        $assetFactory->expects($this->once())->method('createAssetsFromPaths')->with([
            '//my-domain.local/fileadmin/a.webp',
            '//my-domain.local/fileadmin/b.webp',
            '//my-domain.local/fileadmin/c.png',
            '//my-domain.local/fileadmin/d.png'
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
}