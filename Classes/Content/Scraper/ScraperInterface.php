<?php

namespace Aoe\Asdis\Content\Scraper;

use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scraper interface.
 */
interface ScraperInterface
{
    /**
     * @param string $content
     * @return Collection
     */
    public function scrape($content);
}
