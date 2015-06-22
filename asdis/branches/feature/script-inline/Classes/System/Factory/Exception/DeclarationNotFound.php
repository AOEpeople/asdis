<?php

class Tx_Asdis_System_Factory_Exception_DeclarationNotFound extends Exception {

	/**
	 * @param string $key
	 * @param int $code
	 */
	public function __construct($key, $code) {
		parent::__construct('No declaration with key "'.$key.'" found.', $code);
	}
}