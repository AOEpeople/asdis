<?php

$asdisBaseDir = dirname(__FILE__) . '/../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/Content/Scraper/Chain.php';
require_once $asdisBaseDir . 'Classes/Content/Scraper/Html/Image.php';
require_once $asdisBaseDir . 'Classes/Content/Scraper/Html/Script.php';
require_once $asdisBaseDir . 'Classes/Domain/Model/Asset/Collection.php';

/**
 * Tests class Tx_Asdis_Content_Scraper_Chain.
 */
class Tx_Asdis_Content_Scraper_ChainTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @test
	 */
	public function append() {
		$chain = new Tx_Asdis_Content_Scraper_Chain();
		$scraper1 = new Tx_Asdis_Content_Scraper_Html_Image();
		$scraper2 = new Tx_Asdis_Content_Scraper_Html_Script();
		$chain->append($scraper1);
		$chain->append($scraper2);
		$this->assertEquals(2, $chain->count());
	}

	/**
	 * @test
	 */
	public function scrape() {
		/*$chain    = new Tx_Asdis_Content_Scraper_Chain();
		$scraper1 = $this->getMock('Tx_Asdis_Content_Scraper_Html_Image');
		$scraper2 = $this->getMock('Tx_Asdis_Content_Scraper_Html_Script');
		$scraper1->expects($this->once())->method('scrape')->will($this->returnValue(new Tx_Asdis_Domain_Model_Asset_Collection()));
		$scraper2->expects($this->once())->method('scrape')->will($this->returnValue(new Tx_Asdis_Domain_Model_Asset_Collection()));
		$chain->append($scraper1);
		$chain->append($scraper2);
		$chain->scrape('FOO');*/
	}
}

