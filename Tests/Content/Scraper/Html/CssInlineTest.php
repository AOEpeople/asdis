<?php

/**
 * Tx_Asdis_Content_Scraper_Html_CssInline tests.
 */
class Tx_Asdis_Content_Scraper_Html_CssInlineTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_Content_Scraper_Html_CssInline
	 */
	private $scraper;

	/**
	 * (non-PHPdoc)
	 */
	protected function setUp() {
		$this->scraper = new Tx_Asdis_Content_Scraper_Html_CssInline();
	}

	/**
	 * @test
	 */
	public function scrape() {
		$style1 = 'h1 { color: #fff; }';
		$style2 = 'h2 { font-size: 12px; }';
		$content = '<div><style>' . $style1 . '</style><style>' . $style2 . '</style></div>';
		$cssUrlScraper = $this->getMock('Tx_Asdis_Content_Scraper_Css_Url');
		$cssUrlScraper->expects($this->once())->method('scrape')->with($style1 . PHP_EOL . $style2);
		$this->scraper->injectCssUrlScraper($cssUrlScraper);
		$this->scraper->scrape($content);
	}
}

