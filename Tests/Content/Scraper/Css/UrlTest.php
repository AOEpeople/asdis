<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Css;

use Aoe\Asdis\Content\Scraper\Css\Url;
use Aoe\Asdis\Domain\Model\Asset\Factory;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class UrlTest extends UnitTestCase
{
    private Url $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->url = new Url();
    }

    /**
     * Tests Url->scrape()
     */
    public function testScrape(): void
    {
        $factory = $this->getMockBuilder(Factory::class)->getMock();
        $factory->expects($this->once())
            ->method('createAssetsFromPaths')
            ->with([]);

        $this->url->injectAssetFactory($factory);
        $this->url->scrape('');
    }

    /**
     * Tests Url->scrape()
     */
    public function testScrapeWithCss(): void
    {
        $factory = $this->getMockBuilder(Factory::class)->getMock();
        $factory->expects($this->once())
            ->method('createAssetsFromPaths')
            ->with(['uploads/tx_templavoila/example.gif']);

        $this->url->injectAssetFactory($factory);
        $this->url->scrape("filter:url(#secondary);background-image: url('uploads/tx_templavoila/example.gif');");
    }

    /**
     * Tests _Url->scrape()
     */
    public function testScrapeWithInlineCss(): void
    {
        $factory = $this->getMockBuilder(Factory::class)->getMock();
        $factory
            ->expects($this->once())
            ->method('createAssetsFromPaths')
            ->with(['uploads/tx_templavoila/Newsletter_Teaser_Bucket.gif']);

        $this->url->injectAssetFactory($factory);
        $this->url->scrape('url(uploads/tx_templavoila/Newsletter_Teaser_Bucket.gif)');
    }
}
