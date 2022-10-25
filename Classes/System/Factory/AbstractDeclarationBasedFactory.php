<?php

namespace Aoe\Asdis\System\Factory;

use Aoe\Asdis\System\Configuration\Provider;
use Aoe\Asdis\System\Factory\Exception\DeclarationNotFound;
use Aoe\Asdis\System\Factory\Exception\InvalidDeclaration;
use Aoe\Asdis\System\Factory\Exception\MissingImplementation;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Abstract factory class for factories that create their products from array based declarations.
 */
abstract class AbstractDeclarationBasedFactory
{
    /**
     * @var string
     */
    public const DECLARATION_KEY = 'key';

    /**
     * @var string
     */
    public const DECLARATION_CLASS = 'class';

    /**
     * @var string
     */
    public const DECLARATION_FILE = 'file';

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var Provider
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
     * @param ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param Provider $configurationProvider
     */
    public function injectConfigurationProvider(Provider $configurationProvider)
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
        foreach ($declarations as $declaration) {
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
     * @param string $key
     * @return object
     * @throws DeclarationNotFound
     * @throws MissingImplementation
     */
    protected function buildObjectFromKey($key)
    {
        $declaration = null;
        try {
            $declaration = $this->getDeclarationByKey($key);
        } catch (DeclarationNotFound $e) {
            if (isset($this->fallbackKey) === false) {
                throw $e;
            }
            $declaration = $this->getDeclarationByKey($this->fallbackKey);
        }

        if (class_exists($declaration[self::DECLARATION_CLASS]) === false) {
            require_once $declaration[self::DECLARATION_FILE];
        }

        $object = $this->objectManager->get($declaration[self::DECLARATION_CLASS]);
        $implemented = class_implements($object);
        foreach ($this->classImplements as $classImplement) {
            if (in_array($classImplement, $implemented) === false) {
                throw new MissingImplementation(
                    $declaration[self::DECLARATION_CLASS],
                    $classImplement,
                    static::class,
                    1_372_770_673_456
                );
            }
        }
        return $object;
    }

    /**
     * @param array $declaration
     * @throws InvalidDeclaration
     */
    private function addDeclaration(array $declaration): void
    {
        if (
            array_key_exists(self::DECLARATION_KEY, $declaration) === false ||
            array_key_exists(self::DECLARATION_CLASS, $declaration) === false ||
            array_key_exists(self::DECLARATION_FILE, $declaration) === false
        ) {
            throw new InvalidDeclaration(
                'Missing declaration element.',
                1372422185108
            );
        }
        $this->declarations[] = $declaration;
    }

    /**
     * @param $key
     * @return mixed
     * @throws DeclarationNotFound
     */
    private function getDeclarationByKey($key)
    {
        foreach ($this->declarations as $declaration) {
            if (strcmp($declaration[self::DECLARATION_KEY], $key) === 0) {
                return $declaration;
            }
        }
        throw new DeclarationNotFound($key, 1372422430920);
    }
}
