<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scrapes assets from "<image>" tags.
 */
class DataSrc extends AbstractHtmlScraper implements ScraperInterface
{
    public function scrape(string $content): ?Collection
    {
        return $this->getAssets('[A-z]?', 'data-src', $content);
    }
}
