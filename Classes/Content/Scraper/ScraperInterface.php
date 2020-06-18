<?php
namespace Aoe\Asdis\Content\Scraper;

/**
 * Scraper interface.
 */
interface ScraperInterface
{
    /**
     * @param string $content
     * @return \Aoe\Asdis\Domain\Model\Asset\Collection
     */
    public function scrape($content);
}