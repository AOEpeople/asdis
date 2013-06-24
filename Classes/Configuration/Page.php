<?php

class Tx_Asdis_Configuration_Page {

	/**
	 * @return boolean
	 */
	public function isReplacementEnabled() {
		return TRUE;
	}

	/**
	 * @return array
	 */
	public function getScraperKeys() {
		return array('imageTag');
	}
}