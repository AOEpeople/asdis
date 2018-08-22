<?php

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
	 */
	protected function setUp() {
		$this->url = new Tx_Asdis_Content_Scraper_Css_Url();
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
	public function scrapeWithInlineCss() {
		$factory = $this->getMock('Tx_Asdis_Domain_Model_Asset_Factory');
		$factory->expects($this->once())->method('createAssetsFromPaths')->with(array('uploads/tx_templavoila/Newsletter_Teaser_Bucket.gif'));
		$this->url->injectAssetFactory($factory);
		$this->url->scrape("url(uploads/tx_templavoila/Newsletter_Teaser_Bucket.gif)");
	}


}

