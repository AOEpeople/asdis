<?php

/**
 * Chain of filters.
 *
 * @package Tx_Asdis
 * @subpackage System_Uri_Filter
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Uri_Filter_Chain extends ArrayIterator implements Tx_Asdis_System_Uri_Filter_FilterInterface {

	/**
	 * Needs to be called due to an extbase bug.
	 * Hides optional parameters of parent constructor.
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * @param Tx_Asdis_System_Uri_Filter_FilterInterface $filter
	 */
	public function append(Tx_Asdis_System_Uri_Filter_FilterInterface $filter) {
		parent::append($filter);
	}

	/**
	 * @param array $paths Array of paths.
	 * @return array Valid paths.
	 */
	public function filter(array $paths) {
		if($this->count() < 1) {
			return $paths;
		}
		foreach($this as $filter) {
			/** @var Tx_Asdis_System_Uri_Filter_FilterInterface $filter */
			$paths = $filter->filter($paths);
		}
		return $paths;
	}


}