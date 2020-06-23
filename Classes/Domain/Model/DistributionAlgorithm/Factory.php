<?php
namespace Aoe\Asdis\Domain\Model\DistributionAlgorithm;

use Aoe\Asdis\Domain\Model\DistributionAlgorithm\DistributionAlgorithmInterface;
use Aoe\Asdis\System\Factory\AbstractDeclarationBasedFactory;

/**
 * Factory for distribution algorithms.
 */
class Factory extends AbstractDeclarationBasedFactory
{
    /**
     * @param string $key
     * @return \Aoe\Asdis\Domain\Model\DistributionAlgorithm\DistributionAlgorithmInterface
     */
    public function buildDistributionAlgorithmFromKey($key)
    {
        $this->initialize();
        return $this->buildObjectFromKey($key);
    }

    /**
     * @return void
     */
    private function initialize()
    {
        $this->setDeclarations($this->getDeclarations());
        $this->setFallbackKey('hashBasedGroups');
        $this->setClassImplements(['Aoe\Asdis\Domain\Model\DistributionAlgorithm\DistributionAlgorithmInterface']);
    }

    /**
     * @return array
     */
    protected function getDeclarations()
    {
        return $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['distributionAlgorithms'];
    }
}