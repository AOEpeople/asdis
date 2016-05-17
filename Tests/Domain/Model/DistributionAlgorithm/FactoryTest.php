<?php

/**
 * Tx_Asdis_Domain_Model_DistributionAlgorithm_Factory test case.
 */
class Tx_Asdis_Domain_Model_DistributionAlgorithm_FactoryTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @test
	 */
	public function buildDistributionAlgorithmFromKey() {
		global $asdisBaseDir;
		$declarations = array(
			array(
				'key'   => 'hashBasedGroups',
				'class' => 'Tx_Asdis_Domain_Model_DistributionAlgorithm_HashBasedGroups',
				'file'  => $asdisBaseDir . 'Classes/Domain/Model/DistributionAlgorithm/HashBasedGroups.php'
			),
			array(
				'key'   => 'roundRobin',
				'class' => 'Tx_Asdis_Domain_Model_DistributionAlgorithm_RoundRobin',
				'file'  => $asdisBaseDir . 'Classes/Domain/Model/DistributionAlgorithm/RoundRobin.php'
			)
		);
		$factory = $this->getMock('Tx_Asdis_Domain_Model_DistributionAlgorithm_Factory', array('getDeclarations'), array(), '', TRUE);
		$factory->expects($this->once())->method('getDeclarations')->will($this->returnValue($declarations));

		$this->objectManagerMock->method('get')
			->with('Tx_Asdis_Domain_Model_DistributionAlgorithm_HashBasedGroups')
			->willReturn(new Tx_Asdis_Domain_Model_DistributionAlgorithm_HashBasedGroups());

		$factory->injectObjectManager($this->objectManagerMock);

		$algorithm = $factory->buildDistributionAlgorithmFromKey('hashBasedGroups');
		$this->assertEquals('Tx_Asdis_Domain_Model_DistributionAlgorithm_HashBasedGroups', get_class($algorithm));
	}
}

