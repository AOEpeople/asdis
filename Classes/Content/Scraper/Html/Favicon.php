<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scrapes favicon assets from "<link>" tags.
 * @see \Aoe\Asdis\Tests\Content\Scraper\Html\FaviconTest
 */
class Favicon extends AbstractHtmlScraper implements ScraperInterface
{
    public function scrape(string $content): ?Collection
    {
        return $this->getAssets('link', 'href', $content, [
            'rel' => 'shortcut icon',
        ])
            ->merge($this->getAssets('link', 'href', $content, [
                'rel' => 'icon',
            ]))
            ->merge($this->getAssets('link', 'href', $content, [
                'rel' => 'manifest',
            ]))
            ->merge($this->getAssets('link', 'href', $content, [
                'rel' => 'mask-icon',
            ]))
            ->merge($this->getAssets('link', 'href', $content, [
                'type' => 'image/vnd.microsoft.icon',
            ]));
    }
}
