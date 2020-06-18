<?php
namespace Aoe\Asdis\Content\Scraper;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection as AssetCollection;

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
     * @param \Aoe\Asdis\Content\Scraper\ScraperInterface $scraper
     */
    public function append($scraper)
    {
        parent::append($scraper);
    }

    /**
     * @param $content
     * @return \Aoe\Asdis\Domain\Model\Asset\Collection
     */
    public function scrape($content)
    {
        $assetCollection = new AssetCollection();
        foreach($this as $scraper) {
            /** @var \Aoe\Asdis\Content\Scraper\ScraperInterface $scraper */
            $assetCollection->merge($scraper->scrape($content));
        }
        return $assetCollection;
    }
}