<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scrapes assets from "<embed>" tags.
 * @see \Aoe\Asdis\Tests\Content\Scraper\Html\EmbedTest
 */
class Embed extends AbstractHtmlScraper implements ScraperInterface
{
    public function scrape(string $content): ?Collection
    {
        return $this->getAssets('embed', 'src', $content);
    }
}
