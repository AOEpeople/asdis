<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
require_once dirname(__FILE__).'/../../../../Classes/Content/Scraper/Css/Url.php';
require_once dirname(__FILE__).'/../../../../Tests/AbstractTestcase.php';
/**
 * Tx_Asdis_Content_Scraper_Css_Url test case.
 */
class Tx_Asdis_Content_Scraper_Css_UrlTest extends Tx_Asdis_Tests_AbstractTestcase {
	/**
	 * @var Tx_Asdis_Content_Scraper_Css_Url
	 */
	private $url;
	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->url = new Tx_Asdis_Content_Scraper_Css_Url();
	}
	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$this->url = NULL;
	}
	/**
	 * Tests Tx_Asdis_Content_Scraper_Css_Url->scrape()
	 * @test
	 */
	public function scrape() {
		$factory = $this->getMock('Tx_Asdis_Domain_Model_Asset_Factory');
		$factory->expects($this->once())->method('createAssetsFromPaths')->with(array());
		$this->url->injectAssetFactory($factory);
		$this->url->scrape('');
	}
	/**
	 * Tests Tx_Asdis_Content_Scraper_Css_Url->scrape()
	 * @test
	 */
	public function scrapeWithCss() {
		$factory = $this->getMock('Tx_Asdis_Domain_Model_Asset_Factory');
		$factory->expects($this->once())->method('createAssetsFromPaths')->with(array('uploads/tx_templavoila/example.gif'));
		$this->url->injectAssetFactory($factory);
		$this->url->scrape("background-image: url('uploads/tx_templavoila/example.gif');");
	}
	/**
	 * Tests Tx_Asdis_Content_Scraper_Css_Url->scrape()
	 * @test
	 */
	public function scrapeWithUnquotedCss() {
		$factory = $this->getMock('Tx_Asdis_Domain_Model_Asset_Factory');
		$factory->expects($this->once())->method('createAssetsFromPaths')->with(array('uploads/tx_templavoila/example.gif'));
		$this->url->injectAssetFactory($factory);
		$this->url->scrape("background-image: url(uploads/tx_templavoila/example.gif));");
	}
}

