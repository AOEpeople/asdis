<?php

/**
 * Is thrown when a requested filter does not exist.
 *
 * @package Tx_Asdis
 * @subpackage System_Uri_Filter_Exception
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Uri_Filter_Exception_FilterNotExists extends Exception {

	/**
	 * @param string $filterKey
	 */
	public function __construct($filterKey) {
		parent::__construct('Filter with the key ' . $filterKey . ' does not exist.', 1372172405389);
	}
}