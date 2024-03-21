<?php

namespace Aoe\Asdis\Domain\Model\DistributionAlgorithm;

use Aoe\Asdis\System\Factory\AbstractDeclarationBasedFactory;

/**
 * Factory for distribution algorithms.
 * @see \Aoe\Asdis\Tests\Domain\Model\DistributionAlgorithm\FactoryTest
 */
class Factory extends AbstractDeclarationBasedFactory
{
    /**
     * @return DistributionAlgorithmInterface
     */
    public function buildDistributionAlgorithmFromKey(string $key)
    {
        $this->initialize();
        return $this->buildObjectFromKey($key);
    }

    /**
     * @return array
     */
    protected function getDeclarations()
    {
        return $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['distributionAlgorithms'];
    }

    private function initialize(): void
    {
        $this->setDeclarations($this->getDeclarations());
        $this->setFallbackKey('hashBasedGroups');
        $this->setClassImplements([DistributionAlgorithmInterface::class]);
    }
}
