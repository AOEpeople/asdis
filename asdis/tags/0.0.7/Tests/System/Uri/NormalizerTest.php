<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
$asdisBaseDir = dirname(__FILE__) . '/../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/System/Uri/Normalizer.php';
/**
 * Tx_Asdis_System_Uri_Normalizer test case.
 */
class Tx_Asdis_System_Uri_NormalizerTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_System_Uri_Normalizer
	 */
	private $normalizer;

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->normalizer = new Tx_Asdis_System_Uri_Normalizer();

	}

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$this->normalizer = NULL;
	}

	/**
	 * @test
	 */
	public function normalizePath() {
		$this->assertEquals('typo3temp/pics/foo.gif', $this->normalizer->normalizePath('/typo3temp/pics/foo.gif'));
		$this->assertEquals('typo3temp/pics/bar.gif', $this->normalizer->normalizePath('typo3temp/pics/bar.gif'));
	}
}

