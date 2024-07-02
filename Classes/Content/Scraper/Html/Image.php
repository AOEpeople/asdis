<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scrapes assets from "<image>" tags.
 * @see \Aoe\Asdis\Tests\Content\Scraper\Html\ImageTest
 */
class Image extends AbstractHtmlScraper implements ScraperInterface
{
    public function scrape(string $content): ?Collection
    {
        return $this->getAssets('img', 'src', $content)
            ->merge($this->getAssets('image', 'href', $content))
            ->merge($this->getAssets('link', 'href', $content, [
                'type' => 'image/gif',
            ]));
    }
}
