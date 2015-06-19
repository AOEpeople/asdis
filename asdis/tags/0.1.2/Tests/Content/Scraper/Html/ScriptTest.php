<?php

$asdisBaseDir = dirname(__FILE__) . '/../../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/Content/Scraper/Html/Script.php';

/**
 * Tx_Asdis_Content_Scraper_Html_Script tests.
 */
class Tx_Asdis_Content_Scraper_Html_ScriptTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_Content_Scraper_Html_Script
	 */
	private $scraper;

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->scraper = new Tx_Asdis_Content_Scraper_Html_Script();
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
		$content      = '<script type="text/javascript" src="typo3temp/js/main.js" />';
		$assetFactory = $this->getMock('Tx_Asdis_Domain_Model_Asset_Factory');
		$assetFactory->expects($this->once())->method('createAssetsFromPaths')->with(array('typo3temp/js/main.js'));
		$attributeExtractor = $this->getMock('Tx_Asdis_Content_Scraper_Extractor_XmlTagAttribute');
		$attributeExtractor->expects($this->once())->method('getAttributeFromTag')->with('script', 'src', $content)->will($this->returnValue(array('paths' => array('typo3temp/js/main.js'), 'masks' => array('"'))));
		$this->scraper->injectAssetFactory($assetFactory);
		$this->scraper->injectXmlTagAttributeExtractor($attributeExtractor);
		$this->scraper->scrape($content);
	}
}

