<?php

class Tx_Asdis_Domain_Repository_DistributionAlgorithmRepository {

	/**
	 * @param Tx_Asdis_Domain_Model_Page $page
	 * @return Tx_Asdis_Domain_Model_DistributionAlgorithm_DistributionAlgorithmInterface
	 * @todo implement
	 */
	public function findOneByPage(Tx_Asdis_Domain_Model_Page $page) {
		return new Tx_Asdis_Domain_Model_DistributionAlgorithm_RoundRobin();
	}
}