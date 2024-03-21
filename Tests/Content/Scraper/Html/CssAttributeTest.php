<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Css\Url;
use Aoe\Asdis\Content\Scraper\Html\CssAttribute;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class CssAttributeTest extends UnitTestCase
{
    private CssAttribute $cssAttribute;

    protected function setUp(): void
    {
        $this->cssAttribute = new CssAttribute();
    }

    /**
     * Tests Tx_Asdis_Content_Scraper_Css_Url->scrape()
     */
    public function testScrape(): void
    {
        $url = $this->getMockBuilder(Url::class)->getMock();
        $url->expects($this->once())
            ->method('scrape')
            ->with('');

        $this->cssAttribute->injectCssUrlScraper($url);
        $this->cssAttribute->scrape('');
    }

    /**
     * Tests Tx_Asdis_Content_Scraper_Css_Url->scrape()
     */
    public function testScrapeWithCss(): void
    {
        $url = $this->getMockBuilder(Url::class)->getMock();
        $url
            ->expects($this->once())
            ->method('scrape')
            ->with(
                'url(uploads/tx_templavoila/130621_example_Buehne_AllnetFlatS_Aktion_5tage.gif)' . PHP_EOL . 'url(uploads/tx_templavoila/D-Netz_icon_03.gif)' . PHP_EOL . 'url(uploads/tx_templavoila/Newsletter_Teaser_Bucket.gif)'
            );

        $this->cssAttribute->injectCssUrlScraper($url);

        $content = file_get_contents(__DIR__ . '/Fixtures/testPage.html');

        $this->cssAttribute->scrape($content);
    }
}
