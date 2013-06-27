<?php

/**
 * Interface for server repositories.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Repository
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
interface Tx_Asdis_Domain_Repository_ServerRepositoryInterface {

	/**
	 * @param Tx_Asdis_Domain_Model_Page $page
	 * @return Tx_Asdis_Domain_Model_Server_Collection
	 */
	public function findAllByPage(Tx_Asdis_Domain_Model_Page $page);
}