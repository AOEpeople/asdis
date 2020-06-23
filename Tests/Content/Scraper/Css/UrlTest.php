<?php
namespace Aoe\Asdis\Tests\Content\Scraper\Css;

use Aoe\Asdis\Content\Scraper\Css\Url;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class UrlTest extends UnitTestCase
{
    /**
     * @var Url
     */
    private $url;
    /**
     * (non-PHPdoc)
     */
    protected function setUp()
    {
        $this->url = new Url();
    }

    /**
     * Tests Url->scrape()
     * @test
     */
    public function scrape()
    {
        $factory = $this->getMockBuilder(Factory::class)->getMock();
        $factory->expects($this->once())->method('createAssetsFromPaths')->with([]);
        
        $this->url->injectAssetFactory($factory);
        $this->url->scrape('');
    }
    /**
     * Tests Url->scrape()
     * @test
     */
    public function scrapeWithCss()
    {
        $factory = $this->getMockBuilder(Factory::class)->getMock();
        $factory->expects($this->once())->method('createAssetsFromPaths')->with(['uploads/tx_templavoila/example.gif']);
        
        $this->url->injectAssetFactory($factory);
        $this->url->scrape("background-image: url('uploads/tx_templavoila/example.gif');");
    }
    /**
     * Tests _Url->scrape()
     * @test
     */
    public function scrapeWithInlineCss()
    {
        $factory = $this->getMockBuilder(Factory::class)->getMock();
        $factory
            ->expects($this->once())
            ->method('createAssetsFromPaths')
            ->with(['uploads/tx_templavoila/Newsletter_Teaser_Bucket.gif']);

        $this->url->injectAssetFactory($factory);
        $this->url->scrape("url(uploads/tx_templavoila/Newsletter_Teaser_Bucket.gif)");
    }

}
