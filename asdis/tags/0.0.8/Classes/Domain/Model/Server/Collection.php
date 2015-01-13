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
	 * Needs to be called due to an extbase bug.
	 * Hides optional parameters of parent constructor.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * @param Tx_Asdis_Domain_Model_Server $server
	 */
	public function append(Tx_Asdis_Domain_Model_Server $server) {
		parent::append($server);
	}
}