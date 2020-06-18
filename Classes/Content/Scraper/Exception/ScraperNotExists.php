<?php
namespace Aoe\Asdis\Content\Scraper\Exception;

/**
 * Is thrown when a requested scraper does not exist.
 */
class ScraperNotExists extends Exception
{
    /**
     * @param string $filterKey
     */
    public function __construct($filterKey)
    {
        parent::__construct('Scraper with the key ' . $filterKey . ' does not exist.', 1371818682112);
    }
}