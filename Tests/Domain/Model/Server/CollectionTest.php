<?php

/**
 * Tx_Asdis_Domain_Model_Server_Collection test case.
 */
class Tx_Asdis_Domain_Model_Server_CollectionTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @test
	 */
	public function append() {
		$collection = new Tx_Asdis_Domain_Model_Server_Collection();
		$server = new Tx_Asdis_Domain_Model_Server();
		$collection->append($server);
		$this->assertEquals(1, $collection->count());
	}
}

