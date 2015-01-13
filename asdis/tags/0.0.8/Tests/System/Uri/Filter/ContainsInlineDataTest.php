<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
$asdisBaseDir = dirname(__FILE__) . '/../../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/System/Uri/Filter/ContainsInlineData.php';
/**
 * Tx_Asdis_System_Uri_Filter_ContainsInlineData test case.
 */
class Tx_Asdis_System_Uri_Filter_ContainsInlineDataTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_System_Uri_Filter_ContainsInlineData
	 */
	private $filter;

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->filter = new Tx_Asdis_System_Uri_Filter_ContainsInlineData();

	}

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$this->filter = NULL;
	}

	/**
	 * @test
	 */
	public function filter() {
		$paths = array(
			'data:image/png;base64,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',
			'typo3temp/pics/foo.gif'
		);
		$filteredPaths = $this->filter->filter($paths);
		$this->assertInternalType('array', $filteredPaths);
		$this->assertEquals(1, sizeof($filteredPaths));
		$this->assertEquals($paths[1], $filteredPaths[0]);
	}
}

