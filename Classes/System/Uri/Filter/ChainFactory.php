<?php
namespace Aoe\Asdis\System\Uri\Filter;

use Aoe\Asdis\System\Factory\AbstractDeclarationBasedFactory;
use Aoe\Asdis\System\Uri\Filter\Chain;
use Aoe\Asdis\System\Uri\Filter\FilterInterface;

/**
 * Factory for filter chains.
 */
class ChainFactory extends AbstractDeclarationBasedFactory
{
    /**
     * @return \Aoe\Asdis\System\Uri\Filter\Chain
     */
    public function buildChain()
    {
        $this->initialize();
        /** @var \Aoe\Asdis\System\Uri\Filter\Chain $chain */
        $chain = new Chain();
        foreach ($this->configurationProvider->getFilterKeys() as $filterKey) {
            $chain->append($this->buildFilter($filterKey));
        }
        return $chain;
    }

    /**
     * @return void
     */
    private function initialize()
    {
        $this->setDeclarations($this->getDeclarations());
        $this->setClassImplements([FilterInterface::class]);
    }

    /**
     * @param string $filterKey
     * @return \Aoe\Asdis\System\Uri\Filter\FilterInterface
     */
    private function buildFilter($filterKey)
    {
        return $this->buildObjectFromKey($filterKey);
    }

    /**
     * @return array
     */
    protected function getDeclarations()
    {
        return $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['filters'];
    }
}