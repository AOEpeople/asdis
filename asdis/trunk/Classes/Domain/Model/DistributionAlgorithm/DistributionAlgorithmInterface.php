<?php

interface Tx_Asdis_Domain_Model_DistributionAlgorithm_DistributionAlgorithmInterface {

	/**
	 * Distributes the given assets to the given servers.
	 *
	 * @param Tx_Asdis_Domain_Model_Asset_Collection $assets
	 * @param Tx_Asdis_Domain_Model_Server_Collection $servers
	 * @return void
	 */
	public function distribute(Tx_Asdis_Domain_Model_Asset_Collection $assets, Tx_Asdis_Domain_Model_Server_Collection $servers);
}