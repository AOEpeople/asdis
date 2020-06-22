<?php
namespace Aoe\Asdis\Content\Scraper;

use Aoe\Asdis\Content\Scraper\Chain;
use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\System\Factory\AbstractDeclarationBasedFactory;

/**
 * Scraper chain factory.
 */
class ChainFactory extends AbstractDeclarationBasedFactory
{
    /**
     * @return \Aoe\Asdis\Content\Scraper\Chain
     */
    public function buildChain()
    {
        $this->initialize();
        /** @var \Aoe\Asdis\Content\Scraper\Chain $chain */
        $chain = $this->objectManager->get(Chain::class);
        foreach($this->configurationProvider->getScraperKeys() as $scraperKey) {
            $chain->append($this->buildScraper($scraperKey));
        }
        return $chain;
    }

    /**
     * @return void
     */
    private function initialize()
    {
        $this->setDeclarations($this->getScraperDeclarations());
        $this->setClassImplements(['Aoe\Asdis\Content\Scraper\ScraperInterface']);
    }

    /**
     * @param string $scraperKey
     * @return \Aoe\Asdis\Content\Scraper\ScraperInterface
     */
    private function buildScraper($scraperKey)
    {
        return $this->buildObjectFromKey($scraperKey);
    }

    /**
     * @return array
     */
    protected function getScraperDeclarations()
    {
        if (false === isset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'])) {
            return array();
        }
        return $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'];
    }
}