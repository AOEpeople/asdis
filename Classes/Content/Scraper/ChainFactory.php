<?php

namespace Aoe\Asdis\Content\Scraper;

use Aoe\Asdis\System\Factory\AbstractDeclarationBasedFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Scraper chain factory.
 * @see \Aoe\Asdis\Tests\Content\Scraper\ChainFactoryTest
 */
class ChainFactory extends AbstractDeclarationBasedFactory
{
    /**
     * @return Chain
     */
    public function buildChain()
    {
        $this->initialize();
        $chain = GeneralUtility::makeInstance(Chain::class);
        foreach ($this->configurationProvider->getScraperKeys() as $scraperKey) {
            $chain->append($this->buildScraper($scraperKey));
        }

        return $chain;
    }

    protected function getScraperDeclarations(): array
    {
        if (!isset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'])) {
            return [];
        }

        return $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['asdis']['scrapers'];
    }

    private function initialize(): void
    {
        $this->setDeclarations($this->getScraperDeclarations());
        $this->setClassImplements([ScraperInterface::class]);
    }

    /**
     * @return ScraperInterface
     */
    private function buildScraper(string $scraperKey)
    {
        return $this->buildObjectFromKey($scraperKey);
    }
}
