<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scrapes CSS assets from "<link>" tags.
 */
class CssFile extends AbstractHtmlScraper implements ScraperInterface
{
    public function scrape(string $content): ?Collection
    {
        return $this->getAssets('link', 'href', $content, ['rel' => 'stylesheet'])
            ->merge($this->getAssets('link', 'href', $content, ['type' => 'text/css']));
    }
}
