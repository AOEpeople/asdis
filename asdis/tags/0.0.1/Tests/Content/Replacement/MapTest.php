<?php

$asdisBaseDir = dirname(__FILE__) . '/../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';

/**
 * Tests class Tx_Asdis_Content_Replacement_Map.
 */
class Tx_Asdis_Content_Replacement_MapTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_Content_Replacement_Map
	 */
	private $map;

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->map = new Tx_Asdis_Content_Replacement_Map();

	}
	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$this->page = NULL;

	}

	/**
	 * @test
	 */
	public function testAll() {
		$source1 = 'AAA';
		$target1 = 'BBB';
		$source2 = 'XXX';
		$target2 = 'YYY';
		$this->map->addMapping($source1, $target1);
		$this->map->addMapping($source2, $target2);
		$sources = $this->map->getSources();
		$targets = $this->map->getTargets();
		$this->assertInternalType('array', $sources);
	}
}

