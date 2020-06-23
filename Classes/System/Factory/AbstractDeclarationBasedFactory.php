<?php
namespace Aoe\Asdis\System\Factory;

use Aoe\Asdis\System\Factory\Exception\DeclarationNotFound;
use Aoe\Asdis\System\Factory\Exception\InvalidDeclaration;
use Aoe\Asdis\System\Factory\Exception\MissingImplementation;

/**
 * Abstract factory class for factories that create their products from array based declarations.
 */
abstract class AbstractDeclarationBasedFactory
{
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
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var \Aoe\Asdis\System\Configuration\Provider
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
    private $classImplements = [];

    /**
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param \Aoe\Asdis\System\Configuration\Provider $configurationProvider
     */
    public function injectConfigurationProvider(\Aoe\Asdis\System\Configuration\Provider $configurationProvider)
    {
        $this->configurationProvider = $configurationProvider;
    }

    /**
     * @param array $classImplements
     */
    protected function setClassImplements(array $classImplements)
    {
        $this->classImplements = $classImplements;
    }

    /**
     * @param array $declarations
     */
    protected function setDeclarations(array $declarations)
    {
        $this->declarations = [];
        foreach($declarations as $declaration) {
            $this->addDeclaration($declaration);
        }
    }

    /**
     * @param string $fallbackKey
     */
    protected function setFallbackKey($fallbackKey)
    {
        $this->fallbackKey = $fallbackKey;
    }

    /**
     * @param array $declaration
     * @throws \Aoe\Asdis\System\Factory\Exception\InvalidDeclaration
     * @return void
     */
    private function addDeclaration(array $declaration)
    {
        if (
            false === array_key_exists(self::DECLARATION_KEY, $declaration)   ||
            false === array_key_exists(self::DECLARATION_CLASS, $declaration) ||
            false === array_key_exists(self::DECLARATION_FILE, $declaration)
        ) {
            throw new InvalidDeclaration(
                'Missing declaration element.', 1372422185108
            );
        }
        $this->declarations[] = $declaration;
    }

    /**
     * @param string $key
     * @return object
     * @throws \Aoe\Asdis\System\Factory\Exception\DeclarationNotFound
     * @throws \Aoe\Asdis\System\Factory\Exception\MissingImplementation
     */
    protected function buildObjectFromKey($key)
    {
        $declaration = null;
        try {
            $declaration = $this->getDeclarationByKey($key);
        } catch(DeclarationNotFound $e) {
            if (false === isset($this->fallbackKey)) {
                throw $e;
            }
            $declaration = $this->getDeclarationByKey($this->fallbackKey);
        }

        if (false === class_exists($declaration[self::DECLARATION_CLASS])) {
            require_once $declaration[self::DECLARATION_FILE];
        }

        $object = $this->objectManager->get($declaration[self::DECLARATION_CLASS]);
        $implemented = class_implements($object);
        foreach($this->classImplements as $classImplement) {
            if (false === in_array($classImplement, $implemented)) {
                throw new MissingImplementation(
                    $declaration[self::DECLARATION_CLASS], $classImplement, get_class($this), 1372770673456
                );
            }
        }
        return $object;
    }

    /**
     * @param $key
     * @return mixed
     * @throws \Aoe\Asdis\System\Factory\Exception\DeclarationNotFound
     */
    private function getDeclarationByKey($key)
    {
        foreach($this->declarations as $declaration) {
            if (strcmp($declaration[self::DECLARATION_KEY], $key) === 0) {
                return $declaration;
            }
        }
        throw new DeclarationNotFound($key, 1372422430920);
    }
}