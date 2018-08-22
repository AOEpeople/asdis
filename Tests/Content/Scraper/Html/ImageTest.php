<?php

/**
 * Tx_Asdis_Content_Scraper_Html_Image tests.
 */
class Tx_Asdis_Content_Scraper_Html_ImageTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_Content_Scraper_Html_Image
	 */
	private $imageScraper;

	/**
	 * (non-PHPdoc)
	 */
	protected function setUp() {
		$this->imageScraper = new Tx_Asdis_Content_Scraper_Html_Image();
	}

	/**
	 * @test
	 */
	public function scrape() {
		$content = '<image src="uploads/images/foo.gif" />';
		$assetFactory = $this->getMock('Tx_Asdis_Domain_Model_Asset_Factory');
		$assetFactory->expects($this->once())->method('createAssetsFromPaths')->with(array('uploads/tx_templavoila/example.gif'));
		$attributeExtractor = $this->getMock('Tx_Asdis_Content_Scraper_Extractor_XmlTagAttribute');
		$attributeExtractor->expects($this->once())->method('getAttributeFromTag')->with('img', 'src', $content)->will($this->returnValue(array('paths' => array('uploads/tx_templavoila/example.gif'), 'masks' => array('"'))));
		$this->imageScraper->injectAssetFactory($assetFactory);
		$this->imageScraper->injectXmlTagAttributeExtractor($attributeExtractor);
		$this->imageScraper->scrape($content);
	}
}

