<?php

$asdisBaseDir = dirname(__FILE__) . '/../../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/Content/Scraper/Html/Image.php';

/**
 * Tx_Asdis_Content_Scraper_Html_AppleTouchIcon tests.
 */
class Tx_Asdis_Content_Scraper_Html_AppleTouchIconTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_Content_Scraper_Html_AppleTouchIcon
	 */
	private $scraper;

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->scraper = new Tx_Asdis_Content_Scraper_Html_AppleTouchIcon();
	}

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$this->scraper = NULL;
	}

	/**
	 * @test
	 */
	public function scrape() {
		$content      = '<link href="uploads/images/foo.gif" rel="apple-touch-icon-precomposed" /><link href="foo/bar/baz.gif" />';
		$assetFactory = $this->getMock('Tx_Asdis_Domain_Model_Asset_Factory');
		$assetFactory->expects($this->exactly(2))->method('createAssetsFromPaths')->with(array('uploads/images/foo.gif'))->will($this->returnValue(new Tx_Asdis_Domain_Model_Asset_Collection()));;
		$attributeExtractor = $this->getMock('Tx_Asdis_Content_Scraper_Extractor_XmlTagAttribute');
		$attributeExtractor->expects($this->exactly(2))->method('getAttributeFromTag')->will($this->returnValue(array('paths' => array('uploads/images/foo.gif'), 'masks' => array('"'))));
		$this->scraper->injectAssetFactory($assetFactory);
		$this->scraper->injectXmlTagAttributeExtractor($attributeExtractor);
		$this->scraper->scrape($content);
	}
}

