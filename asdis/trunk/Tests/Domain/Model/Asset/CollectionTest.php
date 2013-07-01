<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
$asdisBaseDir = dirname(__FILE__) . '/../../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/Domain/Model/Asset.php';
require_once $asdisBaseDir . 'Classes/Domain/Model/Asset/Collection.php';
/**
 * Tx_Asdis_Domain_Model_Asset_Collection test case.
 */
class Tx_Asdis_Domain_Model_Asset_CollectionTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @test
	 */
	public function append() {
		$collection = new Tx_Asdis_Domain_Model_Asset_Collection();
		$asset      = new Tx_Asdis_Domain_Model_Asset();
		$collection->append($asset);
		$this->assertEquals(1, $collection->count());
	}
}

