<?php

/**
 * A distribution algorithm which is based on the assets hashed filenames.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Model_DistributionAlgorithm
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Domain_Model_DistributionAlgorithm_HashBasedGroups implements Tx_Asdis_Domain_Model_DistributionAlgorithm_DistributionAlgorithmInterface {

	/**
	 * @var string
	 */
	const UNKNOWN_GROUP_KEY = 'unknown';

	/**
	 * @var Tx_Asdis_Domain_Model_Server_Collection
	 */
	private $servers;

	/**
	 * @var string
	 */
	private $characters = '0123456789abcdef';

	/**
	 * @var array
	 */
	private $groups;

	/**
	 * Distributes the given assets to the given servers.
	 *
	 * @param Tx_Asdis_Domain_Model_Asset_Collection $assets
	 * @param Tx_Asdis_Domain_Model_Server_Collection $servers
	 * @return void
	 */
	public function distribute(Tx_Asdis_Domain_Model_Asset_Collection $assets, Tx_Asdis_Domain_Model_Server_Collection $servers) {
		if ($servers->count() < 1) {
			return;
		}
		$this->groups  = array();
		$this->servers = $servers;
		$this->buildGroups();
		foreach ($assets as $asset) {
			/** @var Tx_Asdis_Domain_Model_Asset $asset */
			$asset->setServer($this->groups[$this->getGroupCharacter($asset)]);
		}
	}

	/**
	 * @return Tx_Asdis_Domain_Model_Server
	 */
	private function getNextServer() {
		$server = $this->servers->current();
		$this->servers->next();
		if (FALSE === $this->servers->valid()) {
			$this->servers->rewind();
		}
		return $server;
	}

	/**
	 * @return void
	 */
	private function buildGroups() {
		$serverCount = $this->servers->count();
		$charCount   = strlen($this->characters);
		for($i = 0; $i < $charCount; $i++) {
			$this->groups[$this->characters{$i}] = $this->getNextServer();
		}
		$this->groups[self::UNKNOWN_GROUP_KEY] = $this->getNextServer();
	}

	/**
	 * @param Tx_Asdis_Domain_Model_Asset $asset
	 * @return string
	 */
	private function getGroupCharacter(Tx_Asdis_Domain_Model_Asset $asset) {
		$hash = md5(sha1($asset->getOriginalPath()));
		$character = $hash{strlen($hash) - 3};
		if(FALSE === strpos($this->characters, $character)) {
			return self::UNKNOWN_GROUP_KEY;
		}
		return $character;
	}
}