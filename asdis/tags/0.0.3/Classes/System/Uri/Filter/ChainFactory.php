<?php

/**
 * Factory for filter chains.
 *
 * @package Tx_Asdis
 * @subpackage System_Uri_Filter
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Uri_Filter_ChainFactory extends Tx_Asdis_System_Factory_AbstractDeclarationBasedFactory {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->setDeclarations($this->getDeclarations());
		$this->setClassImplements(array('Tx_Asdis_System_Uri_Filter_FilterInterface'));
	}

	/**
	 * @return Tx_Asdis_System_Uri_Filter_Chain
	 */
	public function buildChain() {
		/** @var Tx_Asdis_System_Uri_Filter_Chain $chain */
		$chain = $this->objectManager->create('Tx_Asdis_System_Uri_Filter_Chain');
		foreach ($this->configurationProvider->getFilterKeys() as $filterKey) {
			$chain->append($this->buildFilter($filterKey));
		}
		return $chain;
	}

	/**
	 * @param string $filterKey
	 * @return Tx_Asdis_System_Uri_Filter_FilterInterface
	 */
	private function buildFilter($filterKey) {
		return $this->buildObjectFromKey($filterKey);
	}

	/**
	 * @return array
	 */
	protected function getDeclarations() {
		return $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['filters'];
	}
}