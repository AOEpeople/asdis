<?php

/**
 * Bootstrapper.
 *
 * @package Tx_Asdis
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Bootstrap {

	/**
	 * @return void
	 */
	public function run() {
		$this->initializeDefaultExtbaseClassMapping();
	}

	/**
	 * Registers default implementations.
	 *
	 * @return void
	 */
	private function initializeDefaultExtbaseClassMapping() {
		/** @var Tx_Extbase_Object_Container_Container $objectContainer */
		$objectContainer = t3lib_div::makeInstance('Tx_Extbase_Object_Container_Container');
		$objectContainer->registerImplementation(
			'Tx_Asdis_System_Log_BackendInterface',
			'Tx_Asdis_System_Log_NullBackend'
		);
		$objectContainer->registerImplementation(
			'Tx_Asdis_Domain_Repository_PageRepositoryInterface',
			'Tx_Asdis_Domain_Repository_PageRepository'
		);
		$objectContainer->registerImplementation(
			'Tx_Asdis_Domain_Repository_ServerRepositoryInterface',
			'Tx_Asdis_Domain_Repository_ServerRepository'
		);
		$objectContainer->registerImplementation(
			'Tx_Asdis_Domain_Model_DistributionAlgorithm_DistributionAlgorithmInterface',
			'Tx_Asdis_Domain_Model_DistributionAlgorithm_HashBasedGroups'
		);
	}
}