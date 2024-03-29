<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scrapes assets from "<input>" tags.
 * @see \Aoe\Asdis\Tests\Content\Scraper\Html\InputImageTest
 */
class InputImage extends AbstractHtmlScraper implements ScraperInterface
{
    public function scrape(string $content): ?Collection
    {
        return $this->getAssets('input', 'src', $content, [
            'type' => 'image',
        ]);
    }
}
