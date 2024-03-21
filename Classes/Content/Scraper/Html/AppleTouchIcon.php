<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scrapes the "href" attribute from "<link>" tags whose rel attribute is "apple-touch-icon" or "apple-touch-icon-precomposed".
 * @see \Aoe\Asdis\Tests\Content\Scraper\Html\AppleTouchIconTest
 */
class AppleTouchIcon extends AbstractHtmlScraper implements ScraperInterface
{
    public function scrape(string $content): ?Collection
    {
        return $this->getAssets('link', 'href', $content, [
            'rel' => 'apple-touch-icon',
        ])
            ->merge($this->getAssets('link', 'href', $content, [
                'rel' => 'apple-touch-icon-precomposed',
            ]));
    }
}
