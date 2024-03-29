<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scrapes assets from "<meta property="og:image">" tags.
 * @see \Aoe\Asdis\Tests\Content\Scraper\Html\OpenGraphImageTest
 */
class OpenGraphImage extends AbstractHtmlScraper implements ScraperInterface
{
    public function scrape(string $content): ?Collection
    {
        return $this->getAssets('meta', 'content', $content, [
            'property' => 'og:image',
        ]);
    }
}
