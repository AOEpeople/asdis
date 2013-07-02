<?php

/**
 * Abstract factory class for factories that create their products from array based declarations.
 *
 * @package Tx_Asdis
 * @subpackage System_Factory
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
abstract class Tx_Asdis_System_Factory_AbstractDeclarationBasedFactory {

	/**
	 * @var string
	 */
	const DECLARATION_KEY = 'key';

	/**
	 * @var string
	 */
	const DECLARATION_CLASS = 'class';

	/**
	 * @var string
	 */
	const DECLARATION_FILE = 'file';

	/**
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var Tx_Asdis_System_Configuration_Provider
	 */
	protected $configurationProvider;

	/**
	 * @var string
	 */
	private $fallbackKey;

	/**
	 * @var array
	 */
	private $declarations;

	/**
	 * @var array
	 */
	private $classImplements = array();

	/**
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * @param Tx_Asdis_System_Configuration_Provider $configurationProvider
	 */
	public function injectConfigurationProvider(Tx_Asdis_System_Configuration_Provider $configurationProvider) {
		$this->configurationProvider = $configurationProvider;
	}

	/**
	 * @param array $classImplements
	 */
	protected function setClassImplements(array $classImplements) {
		$this->classImplements = $classImplements;
	}

	/**
	 * @param array $declarations
	 */
	protected function setDeclarations(array $declarations) {
		$this->declarations = array();
		foreach($declarations as $declaration) {
			$this->addDeclaration($declaration);
		}
	}

	/**
	 * @param string $fallbackKey
	 */
	protected function setFallbackKey($fallbackKey) {
		$this->fallbackKey = $fallbackKey;
	}

	/**
	 * @param array $declaration
	 * @throws Tx_Asdis_System_Factory_Exception_InvalidDeclaration
	 * @return void
	 */
	private function addDeclaration(array $declaration) {
		if(
			FALSE === array_key_exists(self::DECLARATION_KEY, $declaration)   ||
			FALSE === array_key_exists(self::DECLARATION_CLASS, $declaration) ||
			FALSE === array_key_exists(self::DECLARATION_FILE, $declaration)
		) {
			throw new Tx_Asdis_System_Factory_Exception_InvalidDeclaration(
				'Missing declaration element.', 1372422185108
			);
		}
		$this->declarations[] = $declaration;
	}

	/**
	 * @param string $key
	 * @return object
	 * @throws Tx_Asdis_System_Factory_Exception_DeclarationNotFound
	 * @throws Tx_Asdis_System_Factory_Exception_MissingImplementation
	 */
	protected function buildObjectFromKey($key) {
		$declaration = NULL;
		try {
			$declaration = $this->getDeclarationByKey($key);
		} catch(Tx_Asdis_System_Factory_Exception_DeclarationNotFound $e) {
			if(FALSE === isset($this->fallbackKey)) {
				throw $e;
			}
			$declaration = $this->getDeclarationByKey($this->fallbackKey);
		}
		if(FALSE === class_exists($declaration[self::DECLARATION_CLASS])) {
			require_once $declaration[self::DECLARATION_FILE];
		}
		$object = $this->objectManager->get($declaration[self::DECLARATION_CLASS]);
		$implemented = class_implements($object);
		foreach($this->classImplements as $classImplement) {
			if(FALSE === in_array($classImplement, $implemented)) {
				throw new Tx_Asdis_System_Factory_Exception_MissingImplementation(
					$declaration[self::DECLARATION_CLASS], $classImplement, get_class($this), 1372770673456
				);
			}
		}
		return $object;
	}

	/**
	 * @param $key
	 * @return mixed
	 * @throws Tx_Asdis_System_Factory_Exception_DeclarationNotFound
	 */
	private function getDeclarationByKey($key) {
		foreach($this->declarations as $declaration) {
			if(strcmp($declaration[self::DECLARATION_KEY], $key) === 0) {
				return $declaration;
			}
		}
		throw new Tx_Asdis_System_Factory_Exception_DeclarationNotFound($key, 1372422430920);
	}
}