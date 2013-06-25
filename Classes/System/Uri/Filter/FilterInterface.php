<?php

interface Tx_Asdis_System_Uri_Filter_FilterInterface {

	/**
	 * @param array $paths Array of paths.
	 * @return array Valid paths.
	 */
	public function filter(array $paths);
}