<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scrapes Font assets from "<link>" tags.
 * @see \Aoe\Asdis\Tests\Content\Scraper\Html\FontFileTest
 */
class FontFile extends AbstractHtmlScraper implements ScraperInterface
{
    public function scrape(string $content): ?Collection
    {
        return $this->getAssets('link', 'href', $content, [
            'type' => 'font/woff',
        ])
            ->merge($this->getAssets('link', 'href', $content, [
                'type' => 'font/woff2',
            ]))
            ->merge($this->getAssets('link', 'href', $content, [
                'type' => 'font/ttf',
            ]))
            ->merge($this->getAssets('link', 'href', $content, [
                'type' => 'font/otf',
            ]))
            ->merge($this->getAssets('link', 'href', $content, [
                'type' => 'image/svg+xml',
            ]))
            ->merge($this->getAssets('link', 'href', $content, [
                'type' => 'application/vnd.ms-fontobject',
            ]));
    }
}
