<?php

/**
 * Class Tx_Asdis_System_Factory_Exception_MissingImplementation.
 *
 * @package Tx_Asdis
 * @subpackage System_Factory_Exception
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Factory_Exception_MissingImplementation extends Exception {

	/**
	 * @param string $objectClassName
	 * @param string $implementationClassName
	 * @param string $factoryClassName
	 * @param integer $code
	 */
	public function __construct($objectClassName, $implementationClassName, $factoryClassName, $code) {
		parent::__construct(
			'Unable to create object of class "'.$objectClassName.'" in factory "'.$factoryClassName.'". '.
			'Implementation of "'.$implementationClassName.'" is missing.',
			$code
		);
	}
}