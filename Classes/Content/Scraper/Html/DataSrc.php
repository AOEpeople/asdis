<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scrapes assets from "<image>" tags.
 */
class DataSrc extends AbstractHtmlScraper implements ScraperInterface
{
    /**
     * @param $content
     * @return Collection
     */
    public function scrape($content)
    {
        return $this->getAssets('[A-z]?', 'data-src', $content);
    }
}
