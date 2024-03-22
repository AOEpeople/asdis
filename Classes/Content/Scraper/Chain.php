<?php

namespace Aoe\Asdis\Content\Scraper;

use Aoe\Asdis\Domain\Model\Asset\Collection;
use ArrayIterator;

/**
 * Scraper which chains other scrapers.
 * @see \Aoe\Asdis\Tests\Content\Scraper\ChainTest
 */
class Chain extends ArrayIterator implements ScraperInterface
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
     * @param ScraperInterface $value
     */
    public function append($value): void
    {
        parent::append($value);
    }

    public function scrape(string $content): Collection
    {
        $assetColection = new Collection();
        foreach ($this as $scraper) {
            /** @var ScraperInterface $scraper */
            $assetColection->merge($scraper->scrape($content));
        }

        return $assetColection;
    }
}
