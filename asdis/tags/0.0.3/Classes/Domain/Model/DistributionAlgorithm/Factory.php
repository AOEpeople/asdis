<?php

/**
 * Factory for distribution algorithms.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Model_DistributionAlgorithm
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Domain_Model_DistributionAlgorithm_Factory extends Tx_Asdis_System_Factory_AbstractDeclarationBasedFactory {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->setDeclarations($this->getDeclarations());
		$this->setFallbackKey('hashBasedGroups');
		$this->setClassImplements(array('Tx_Asdis_Domain_Model_DistributionAlgorithm_DistributionAlgorithmInterface'));
	}

	/**
	 * @param string $key
	 * @return Tx_Asdis_Domain_Model_DistributionAlgorithm_DistributionAlgorithmInterface
	 */
	public function buildDistributionAlgorithmFromKey($key) {
		return $this->buildObjectFromKey($key);
	}

	/**
	 * @return array
	 */
	protected function getDeclarations() {
		return $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['distributionAlgorithms'];
	}
}