<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Html\AbstractHtmlScraper;
use Aoe\Asdis\Content\Scraper\ScraperInterface;

/**
 * Scrapes Font assets from "<link>" tags.
 */
class FontFile extends AbstractHtmlScraper implements ScraperInterface
{
    /**
     * @param $content
     * @return \Aoe\Asdis\Domain\Model\Asset\Collection
     */
    public function scrape($content)
    {
        return
            $this->getAssets('link', 'href', $content, ['type' => 'font/woff'])
                ->merge($this->getAssets('link', 'href', $content, ['type' => 'font/woff2']))
                ->merge($this->getAssets('link', 'href', $content, ['type' => 'font/ttf']))
                ->merge($this->getAssets('link', 'href', $content, ['type' => 'font/otf']))
                ->merge($this->getAssets('link', 'href', $content, ['type' => 'image/svg+xml']))
                ->merge($this->getAssets('link', 'href', $content, ['type' => 'application/vnd.ms-fontobject']));
    }
}