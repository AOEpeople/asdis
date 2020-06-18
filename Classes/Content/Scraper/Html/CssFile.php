<?php
namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Html\AbstractHtmlScraper;
use Aoe\Asdis\Content\Scraper\ScraperInterface;

/**
 * Scrapes CSS assets from "<link>" tags.
 */
class CssFile extends AbstractHtmlScraper implements ScraperInterface
{
    /**
     * @param $content
     * @return \Aoe\Asdis\Domain\Model\Asset\Collection
     */
    public function scrape($content)
    {
        return
            $this->getAssets('link', 'href', $content, ['rel' => 'stylesheet'])
                ->merge($this->getAssets('link', 'href', $content, ['type' => 'text/css']));
    }
}