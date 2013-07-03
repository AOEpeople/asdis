<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
require_once dirname(__FILE__).'/../../../../Classes/Content/Scraper/Html/CssAttribute.php';
require_once dirname(__FILE__).'/../../../../Tests/AbstractTestcase.php';
/**
 * Tx_Asdis_Content_Scraper_Html_CssAttribute test case.
 */
class Tx_Asdis_Content_Scraper_Html_CssAttributeTest extends Tx_Asdis_Tests_AbstractTestcase {
	/**
	 * @var Tx_Asdis_Content_Scraper_Html_CssAttribute
	 */
	private $cssAttribute;
	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->cssAttribute = new Tx_Asdis_Content_Scraper_Html_CssAttribute();
	}
	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$this->cssAttribute = NULL;
	}
	/**
	 * Tests Tx_Asdis_Content_Scraper_Css_Url->scrape()
	 * @test
	 */
	public function scrape() {
		$url = $this->getMock('Tx_Asdis_Content_Scraper_Css_Url');
		$url->expects($this->once())->method('scrape')->with('');
		$this->cssAttribute->injectCssUrlScraper($url);
		$this->cssAttribute->scrape('');
	}
	/**
	 * Tests Tx_Asdis_Content_Scraper_Css_Url->scrape()
	 * @test
	 */
	public function scrapeWithCss() {
		$url = $this->getMock('Tx_Asdis_Content_Scraper_Css_Url');
		$url->expects($this->once())->method('scrape')->with('url(uploads/tx_templavoila/130621_example_Buehne_AllnetFlatS_Aktion_5tage.gif)'.PHP_EOL.'url(uploads/tx_templavoila/D-Netz_icon_03.gif)'.PHP_EOL.'url(uploads/tx_templavoila/Newsletter_Teaser_Bucket.gif)');
		$this->cssAttribute->injectCssUrlScraper($url);
		$content = file_get_contents(dirname(__FILE__).'/Fixtures/testPage.html');
		$this->cssAttribute->scrape($content);
	}
}

