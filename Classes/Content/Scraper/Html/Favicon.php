<?php
namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Html\AbstractHtmlScraper;
use Aoe\Asdis\Content\Scraper\ScraperInterface;

/**
 * Scrapes favicon assets from "<link>" tags.
 */
class Favicon extends AbstractHtmlScraper implements ScraperInterface
{
    /**
     * @param $content
     * @return \Aoe\Asdis\Domain\Model\Asset\Collection
     */
    public function scrape($content)
    {
        return
            $this->getAssets('link', 'href', $content, ['rel' => 'shortcut icon'])
                ->merge($this->getAssets('link', 'href', $content, ['rel' => 'icon']))
                ->merge($this->getAssets('link', 'href', $content, ['rel' => 'manifest']))
                ->merge($this->getAssets('link', 'href', $content, ['rel' => 'mask-icon']))
                ->merge($this->getAssets('link', 'href', $content, ['type' => 'image/vnd.microsoft.icon']));
    }
}