<?php

class Tx_Asdis_Domain_Repository_ServerRepository {

	/**
	 * @param Tx_Asdis_Domain_Model_Page $page
	 * @return Tx_Asdis_Domain_Model_Server_Collection
	 * @todo implement
	 */
	public function findAllByPage(Tx_Asdis_Domain_Model_Page $page) {
		$servers = new Tx_Asdis_Domain_Model_Server_Collection();
		$server = new Tx_Asdis_Domain_Model_Server();
		$server->setDomain('media1.dev-tf.congstar-nico.aoe-works.de');
		$server->setIdentifier('media1');
		$server->setProtocol(Tx_Asdis_Domain_Model_Server::PROTOCOL_HTTP);
		$servers->append($server);
		return $servers;
	}
}