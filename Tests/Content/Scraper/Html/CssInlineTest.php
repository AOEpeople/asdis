<?php

namespace Aoe\Asdis\Tests\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Css\Url;
use Aoe\Asdis\Content\Scraper\Html\CssInline;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class CssInlineTest extends UnitTestCase
{
    private CssInline $scraper;

    protected function setUp(): void
    {
        $this->scraper = new CssInline();
    }

    public function testScrape(): void
    {
        $style1 = 'h1 { color: #fff; }';
        $style2 = 'h2 { font-size: 12px; }';

        $content = '<div><style>' . $style1 . '</style><style>' . $style2 . '</style></div>';

        $cssUrlScraper = $this->getMockBuilder(Url::class)->getMock();
        $cssUrlScraper->expects($this->once())
            ->method('scrape')
            ->with($style1 . PHP_EOL . $style2);

        $this->scraper->injectCssUrlScraper($cssUrlScraper);
        $this->scraper->scrape($content);
    }
}
