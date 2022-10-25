<?php

namespace Aoe\Asdis\System\Uri\Filter;

use Aoe\Asdis\System\Factory\AbstractDeclarationBasedFactory;

/**
 * Factory for filter chains.
 */
class ChainFactory extends AbstractDeclarationBasedFactory
{
    public function buildChain(): Chain
    {
        $this->initialize();
        $chain = new Chain();
        foreach ($this->configurationProvider->getFilterKeys() as $filterKey) {
            $chain->append($this->buildFilter($filterKey));
        }
        return $chain;
    }

    protected function getDeclarations(): array
    {
        return $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['filters'];
    }

    private function initialize(): void
    {
        $this->setDeclarations($this->getDeclarations());
        $this->setClassImplements([FilterInterface::class]);
    }

    /**
     * @return \Aoe\Asdis\System\Uri\Filter\FilterInterface
     */
    private function buildFilter(string $filterKey)
    {
        return $this->buildObjectFromKey($filterKey);
    }
}
