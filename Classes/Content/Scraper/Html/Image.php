<?php
namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Html\AbstractHtmlScraper;
use Aoe\Asdis\Content\Scraper\ScraperInterface;

/**
 * Scrapes assets from "<image>" tags.
 */
class Image extends AbstractHtmlScraper implements ScraperInterface
{
    /**
     * @param $content
     * @return \Aoe\Asdis\Domain\Model\Asset\Collection
     */
    public function scrape($content)
    {
        return $this->getAssets('img', 'src', $content);
    }
}