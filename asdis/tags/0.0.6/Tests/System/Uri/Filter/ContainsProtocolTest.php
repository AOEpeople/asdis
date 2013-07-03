<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
$asdisBaseDir = dirname(__FILE__) . '/../../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/System/Uri/Filter/ContainsProtocol.php';
/**
 * Tx_Asdis_System_Uri_Filter_ContainsProtocol test case.
 */
class Tx_Asdis_System_Uri_Filter_ContainsProtocolTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_System_Uri_Filter_ContainsProtocol
	 */
	private $filter;

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->filter = new Tx_Asdis_System_Uri_Filter_ContainsProtocol();

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
			'http://typo3temp/pics/foo.gif',
			'https://typo3temp/pics/foo.gif',
			'###HTTP_S###typo3temp/pics/foo.gif',
			'typo3temp/pics/foo.jpg'
		);
		$filteredPaths = $this->filter->filter($paths);
		$this->assertInternalType('array', $filteredPaths);
		$this->assertEquals(1, sizeof($filteredPaths));
		$this->assertEquals($paths[3], $filteredPaths[0]);
	}
}

