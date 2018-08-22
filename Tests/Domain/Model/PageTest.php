<?php

/**
 * Tx_Asdis_Domain_Model_Page test case.
 */
class Tx_Asdis_Domain_Model_PageTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_Domain_Model_Page
	 */
	private $page;
	/**
	 * (non-PHPdoc)
	 */
	protected function setUp() {
		$this->page = new Tx_Asdis_Domain_Model_Page();

	}
	/**
	 * Tests Tx_Asdis_Domain_Model_Page->scrapeAssets()
	 * @test
	 */
	public function scrapeAssets() {
		$config = $this->getMock('Tx_Asdis_System_Configuration_Provider');
		$config->expects($this->any())->method('isReplacementEnabled')->will($this->returnValue(FALSE));
		$this->page->injectConfigurationProvider($config);
		$this->assertNull($this->page->scrapeAssets());
	}
}

