<?php

class Tx_Asdis_Domain_Model_DistributionAlgorithm_RoundRobin implements Tx_Asdis_Domain_Model_DistributionAlgorithm_DistributionAlgorithmInterface {

	/**
	 * @var Tx_Asdis_Domain_Model_Server_Collection
	 */
	private $servers;

	/**
	 * Distributes the given assets to the given servers.
	 *
	 * @param Tx_Asdis_Domain_Model_Asset_Collection $assets
	 * @param Tx_Asdis_Domain_Model_Server_Collection $servers
	 * @return void
	 */
	public function distribute(Tx_Asdis_Domain_Model_Asset_Collection $assets, Tx_Asdis_Domain_Model_Server_Collection $servers) {
		if($servers->count() < 1) {
			return;
		}
		$this->servers = $servers;
		foreach($assets as $asset) {
			/** @var Tx_Asdis_Domain_Model_Asset $asset */
			$asset->setServer($this->getNextServer());
		}
	}

	/**
	 * @return Tx_Asdis_Domain_Model_Server
	 */
	private function getNextServer() {
		$server = $this->servers->current();
		$this->servers->next();
		if(FALSE === $this->servers->valid()) {
			$this->servers->rewind();
		}
		return $server;
	}
}