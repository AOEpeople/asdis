<?php

/**
 * Factory for filter chains.
 *
 * @package Tx_Asdis
 * @subpackage System_Uri_Filter
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Uri_Filter_ChainFactory {

	/**
	 * @var string
	 */
	const DECLARATION_KEY_KEY = 'key';

	/**
	 * @var string
	 */
	const DECLARATION_KEY_CLASS = 'class';

	/**
	 * @var string
	 */
	const DECLARATION_KEY_FILE = 'file';

	/**
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	private $objectManager;

	/**
	 * @var Tx_Asdis_System_Configuration_Provider
	 */
	private $configurationProvider;

	/**
	 * @param Tx_Extbase_Object_ObjectManager $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManager $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * @param Tx_Asdis_System_Configuration_Provider $configurationProvider
	 */
	public function injectConfigurationProvider(Tx_Asdis_System_Configuration_Provider $configurationProvider) {
		$this->configurationProvider = $configurationProvider;
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
	 * @throws Tx_Asdis_System_Uri_Filter_Exception_InvalidFilterDefinition
	 * @throws Tx_Asdis_System_Uri_Filter_Exception_FilterNotExists
	 */
	private function buildFilter($filterKey) {
		foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['filters'] as $filterDeclaration) {
			if ($filterKey !== $filterDeclaration[self::DECLARATION_KEY_KEY]) {
				continue;
			}
			if (FALSE === class_exists($filterDeclaration[self::DECLARATION_KEY_CLASS])) {
				require_once($filterDeclaration[self::DECLARATION_KEY_FILE]);
			}
			$filter = $this->objectManager->create($filterDeclaration[self::DECLARATION_KEY_CLASS]);
			if (FALSE === $filter instanceof Tx_Asdis_System_Uri_Filter_FilterInterface) {
				throw new Tx_Asdis_System_Uri_Filter_Exception_InvalidFilterDefinition(
					'Filter "' . $filterDeclaration[self::DECLARATION_KEY_CLASS] . '" does not implement filter interface.'
				);
			}
			return $filter;
		}
		throw new Tx_Asdis_System_Uri_Filter_Exception_FilterNotExists($filterKey);
	}
}