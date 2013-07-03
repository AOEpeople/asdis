<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
$asdisBaseDir = dirname(__FILE__) . '/../../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/System/Uri/Filter/TooShort.php';
/**
 * Tx_Asdis_System_Uri_Filter_TooShort test case.
 */
class Tx_Asdis_System_Uri_Filter_TooShortTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_System_Uri_Filter_TooShort
	 */
	private $filter;

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->filter = new Tx_Asdis_System_Uri_Filter_TooShort();

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
		$paths         = array(
			'',
			'test',
			'typo3temp/pics/foo.gif'
		);
		$filteredPaths = $this->filter->filter($paths);
		$this->assertInternalType('array', $filteredPaths);
		$this->assertEquals(1, sizeof($filteredPaths));
		$this->assertEquals($paths[2], $filteredPaths[0]);
	}
}

