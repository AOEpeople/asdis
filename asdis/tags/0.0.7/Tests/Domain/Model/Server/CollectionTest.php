<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
$asdisBaseDir = dirname(__FILE__) . '/../../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/Domain/Model/Server.php';
require_once $asdisBaseDir . 'Classes/Domain/Model/Server/Collection.php';
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

