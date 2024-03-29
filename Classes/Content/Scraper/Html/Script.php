<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scrapes assets from "<script>" tags.
 * @see \Aoe\Asdis\Tests\Content\Scraper\Html\ScriptTest
 */
class Script extends AbstractHtmlScraper implements ScraperInterface
{
    public function scrape(string $content): ?Collection
    {
        return $this->getAssets('script', 'src', $content);
    }
}
