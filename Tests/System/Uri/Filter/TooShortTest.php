<?php

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
	 */
	protected function setUp() {
		$this->filter = new Tx_Asdis_System_Uri_Filter_TooShort();

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

