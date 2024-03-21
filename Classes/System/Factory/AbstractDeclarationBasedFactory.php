<?php

namespace Aoe\Asdis\System\Factory;

use Aoe\Asdis\System\Configuration\Provider;
use Aoe\Asdis\System\Factory\Exception\DeclarationNotFound;
use Aoe\Asdis\System\Factory\Exception\InvalidDeclaration;
use Aoe\Asdis\System\Factory\Exception\MissingImplementation;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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

    protected ?Provider $configurationProvider = null;

    private ?string $fallbackKey = null;

    private array $declarations = [];

    private array $classImplements = [];

    public function injectConfigurationProvider(Provider $configurationProvider): void
    {
        $this->configurationProvider = $configurationProvider;
    }

    protected function setClassImplements(array $classImplements): void
    {
        $this->classImplements = $classImplements;
    }

    protected function setDeclarations(array $declarations): void
    {
        $this->declarations = [];
        foreach ($declarations as $declaration) {
            $this->addDeclaration($declaration);
        }
    }

    protected function setFallbackKey(string $fallbackKey): void
    {
        $this->fallbackKey = $fallbackKey;
    }

    /**
     * @return object
     */
    protected function buildObjectFromKey(string $key)
    {
        $declaration = null;
        try {
            $declaration = $this->getDeclarationByKey($key);
        } catch (DeclarationNotFound $declarationNotFound) {
            if (!isset($this->fallbackKey)) {
                throw $declarationNotFound;
            }

            $declaration = $this->getDeclarationByKey($this->fallbackKey);
        }

        if (!class_exists($declaration[self::DECLARATION_CLASS])) {
            require_once $declaration[self::DECLARATION_FILE];
        }

        $object = GeneralUtility::makeInstance($declaration[self::DECLARATION_CLASS]);
        $implemented = class_implements($object);
        foreach ($this->classImplements as $classImplement) {
            if (!in_array($classImplement, $implemented)) {
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

    private function addDeclaration(array $declaration): void
    {
        if (
            !array_key_exists(self::DECLARATION_KEY, $declaration) ||
            !array_key_exists(self::DECLARATION_CLASS, $declaration) ||
            !array_key_exists(self::DECLARATION_FILE, $declaration)
        ) {
            throw new InvalidDeclaration(
                'Missing declaration element.',
                1_372_422_185_108
            );
        }

        $this->declarations[] = $declaration;
    }

    /**
     * @return mixed
     */
    private function getDeclarationByKey(string $key)
    {
        foreach ($this->declarations as $declaration) {
            if (strcmp($declaration[self::DECLARATION_KEY], $key) === 0) {
                return $declaration;
            }
        }

        throw new DeclarationNotFound($key, 1_372_422_430_920);
    }
}
