<?php
namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Html\AbstractHtmlScraper;
use Aoe\Asdis\Content\Scraper\ScraperInterface;

/**
 * Scrapes assets from "<image>" tags.
 */
class DataSrc extends AbstractHtmlScraper implements ScraperInterface
{
    /**
     * @param $content
     * @return Tx_Asdis_Domain_Model_Asset_Collection
     */
    public function scrape($content)
    {
        return $this->getAssets('[A-z]?', 'data-src', $content);
    }
}