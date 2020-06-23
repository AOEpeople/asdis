<?php
namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Html\AbstractHtmlScraper;
use Aoe\Asdis\Content\Scraper\ScraperInterface;

/**
 * Scrapes assets from "<meta property="og:image">" tags.
 */
class MetaMsApplication extends AbstractHtmlScraper implements ScraperInterface
{
    /**
     * @param $content
     * @return \Aoe\Asdis\Domain\Model\Asset\Collection
     */
    public function scrape($content)
    {
        return $this->getAssets('meta', 'content', $content, ['name' => 'msapplication-TileImage'])
            ->merge($this->getAssets('meta', 'content', $content, ['name' => 'msapplication-config']));
    }
}