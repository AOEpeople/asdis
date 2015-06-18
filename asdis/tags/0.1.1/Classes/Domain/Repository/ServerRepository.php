<?php

/**
 * Repository for server objects.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Model
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Domain_Repository_ServerRepository {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * @var Tx_Asdis_System_Configuration_Provider
	 */
	private $configurationProvider;

	/**
	 * @var Tx_Asdis_Domain_Model_Server_Factory
	 */
	private $serverFactory;

	/**
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * @param Tx_Asdis_System_Configuration_Provider $configurationProvider
	 */
	public function injectConfigurationProvider(Tx_Asdis_System_Configuration_Provider $configurationProvider) {
		$this->configurationProvider = $configurationProvider;
	}

	/**
	 * @param Tx_Asdis_Domain_Model_Server_Factory $serverFactory
	 */
	public function injectServerFactory(Tx_Asdis_Domain_Model_Server_Factory $serverFactory) {
		$this->serverFactory = $serverFactory;
	}

	/**
	 * @param Tx_Asdis_Domain_Model_Page $page
	 * @return Tx_Asdis_Domain_Model_Server_Collection
	 */
	public function findAllByPage(Tx_Asdis_Domain_Model_Page $page) {
		/** @var Tx_Asdis_Domain_Model_Server_Collection $servers */
		$servers = $this->objectManager->get('Tx_Asdis_Domain_Model_Server_Collection');
		$serverDefinitions = $this->configurationProvider->getServerDefinitions();
		foreach($serverDefinitions as $serverDefinition) {
			$servers->append($this->serverFactory->createServer(
				$serverDefinition['identifier'],
				$serverDefinition['domain'],
				$serverDefinition['protocol']
			));
		}
		return $servers;
	}


}