<?php

/**
 * Tx_Asdis_System_Uri_Filter_WildcardProtocol test case.
 */
class Tx_Asdis_System_Uri_Filter_WildcardProtocolTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_System_Uri_Filter_WildcardProtocol
	 */
	private $filter;

	/**
	 * (non-PHPdoc)
	 */
	protected function setUp() {
		$this->filter = new Tx_Asdis_System_Uri_Filter_WildcardProtocol();

	}

	/**
	 * @test
	 */
	public function filter() {
		$paths         = array(
			'//typo3temp/pics/foo.gif',
			'https://typo3temp/pics/foo.gif'
		);
		$filteredPaths = $this->filter->filter($paths);
		$this->assertInternalType('array', $filteredPaths);
		$this->assertEquals(1, sizeof($filteredPaths));
		$this->assertEquals($paths[1], $filteredPaths[0]);
	}
}

