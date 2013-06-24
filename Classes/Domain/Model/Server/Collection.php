<?php

/**
 * Collection which contains server objects.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Model_Server
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Domain_Model_Server_Collection extends ArrayIterator {

	/**
	 * @param Tx_Asdis_Domain_Model_Server $server
	 */
	public function append(Tx_Asdis_Domain_Model_Server $server) {
		parent::append($server);
	}
}