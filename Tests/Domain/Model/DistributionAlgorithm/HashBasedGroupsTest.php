<?php

/**
 * Tx_Asdis_Domain_Model_DistributionAlgorithm_HashBasedGroups test case.
 */
class Tx_Asdis_Domain_Model_DistributionAlgorithm_HashBasedGroupsTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_Domain_Model_DistributionAlgorithm_HashBasedGroups
	 */
	private $algorithm;

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->algorithm = new Tx_Asdis_Domain_Model_DistributionAlgorithm_HashBasedGroups();
	}

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$this->algorithm = NULL;
	}

	/**
	 * @test
	 */
	public function distribute() {
		$assets = new Tx_Asdis_Domain_Model_Asset_Collection();
		$asset1 = new Tx_Asdis_Domain_Model_Asset();
		$asset2 = new Tx_Asdis_Domain_Model_Asset();
		$asset3 = new Tx_Asdis_Domain_Model_Asset();
		$asset1->setOriginalPath('/typo3temp/1.gif');
		$asset2->setOriginalPath('/typo3temp/2.gif');
		$asset3->setOriginalPath('/typo3temp/3.gif');
		$assets->append($asset1);
		$assets->append($asset2);
		$assets->append($asset3);
		$servers = new Tx_Asdis_Domain_Model_Server_Collection();
		$server1 = new Tx_Asdis_Domain_Model_Server();
		$server2 = new Tx_Asdis_Domain_Model_Server();
		$servers->append($server1);
		$servers->append($server2);
		$this->algorithm->distribute($assets, $servers);
		$this->assertEquals('Tx_Asdis_Domain_Model_Server', get_class($asset1->getServer()));
		$this->assertEquals('Tx_Asdis_Domain_Model_Server', get_class($asset2->getServer()));
		$this->assertEquals('Tx_Asdis_Domain_Model_Server', get_class($asset3->getServer()));
	}
}

