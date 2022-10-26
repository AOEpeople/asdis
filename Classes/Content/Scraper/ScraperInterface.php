<?php

namespace Aoe\Asdis\Content\Scraper;

use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scraper interface.
 */
interface ScraperInterface
{
    public function scrape(string $content): ?Collection;
}
