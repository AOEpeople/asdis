<?php
namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Html\AbstractHtmlScraper;
use Aoe\Asdis\Content\Scraper\ScraperInterface;

/**
 * Scrapes the "href" attribute from "<link>" tags whose rel attribute is "apple-touch-icon" or "apple-touch-icon-precomposed".
 */
class AppleTouchIcon extends AbstractHtmlScraper implements ScraperInterface
{
    /**
     * @param string $content
     * @return \Aoe\Asdis\Domain\Model\Asset\Collection
     */
    public function scrape($content)
    {
        return $this->getAssets('link', 'href', $content, ['rel' => 'apple-touch-icon'])
            ->merge($this->getAssets('link', 'href', $content, ['rel' => 'apple-touch-icon-precomposed']));
    }
}