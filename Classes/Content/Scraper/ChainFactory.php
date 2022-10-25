<?php

namespace Aoe\Asdis\Content\Scraper;

use Aoe\Asdis\System\Factory\AbstractDeclarationBasedFactory;

/**
 * Scraper chain factory.
 */
class ChainFactory extends AbstractDeclarationBasedFactory
{
    /**
     * @return Chain
     */
    public function buildChain()
    {
        $this->initialize();
        /** @var Chain $chain */
        $chain = $this->objectManager->get(Chain::class);
        foreach ($this->configurationProvider->getScraperKeys() as $scraperKey) {
            $chain->append($this->buildScraper($scraperKey));
        }
        return $chain;
    }

    /**
     * @return array
     */
    protected function getScraperDeclarations()
    {
        if (isset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers']) === false) {
            return [];
        }
        return $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'];
    }

    private function initialize()
    {
        $this->setDeclarations($this->getScraperDeclarations());
        $this->setClassImplements(['Aoe\Asdis\Content\Scraper\ScraperInterface']);
    }

    /**
     * @param string $scraperKey
     * @return ScraperInterface
     */
    private function buildScraper($scraperKey)
    {
        return $this->buildObjectFromKey($scraperKey);
    }
}
