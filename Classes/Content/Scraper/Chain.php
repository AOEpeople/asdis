<?php

namespace Aoe\Asdis\Content\Scraper;

use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scraper which chains other scrapers.
 */
class Chain extends \ArrayIterator implements ScraperInterface
{
    /**
     * Needs to be called due to an extbase bug.
     * Hides optional parameters of parent constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param ScraperInterface $scraper
     */
    public function append($scraper)
    {
        parent::append($scraper);
    }

    public function scrape(string $content): Collection
    {
        $assetCollection = new Collection();
        foreach ($this as $scraper) {
            /** @var ScraperInterface $scraper */
            $assetCollection->merge($scraper->scrape($content));
        }
        return $assetCollection;
    }
}
