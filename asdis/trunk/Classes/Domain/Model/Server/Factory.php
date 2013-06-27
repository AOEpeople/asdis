<?php

/**
 * Factory for server objects.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Model
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Domain_Model_Server_Factory {

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * @param string $identifier
	 * @param string $domain
	 * @param string $protocol
	 * @return Tx_Asdis_Domain_Model_Server
	 */
	public function createServer($identifier, $domain, $protocol) {
		/** @var Tx_Asdis_Domain_Model_Server $server */
		$server = $this->objectManager->create('Tx_Asdis_Domain_Model_Server');
		$server->setIdentifier($identifier);
		$server->setDomain($domain);
		$server->setProtocol($protocol);
		return $server;
	}
}