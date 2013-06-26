<?php

/**
 * Common page repository interface.
 * Since Asdis does not persist anything, feel free to code your own implementation.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Repository
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
interface Tx_Asdis_Domain_Repository_PageRepositoryInterface {

	/**
	 * @param tslib_fe $pageObject
	 * @return Tx_Asdis_Domain_Model_Page
	 */
	public function findOneByPageObject(tslib_fe $pageObject);
}