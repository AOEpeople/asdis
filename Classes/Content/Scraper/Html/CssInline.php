<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Css\Url;
use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scrapes assets from inline CSS.
 */
class CssInline implements ScraperInterface
{
    /**
     * @var Url
     */
    private $cssUrlScraper;

    /**
     * @param Url $cssUrlScraper
     */
    public function injectCssUrlScraper(Url $cssUrlScraper)
    {
        $this->cssUrlScraper = $cssUrlScraper;
    }

    /**
     * @param $content
     * @return Collection
     */
    public function scrape($content)
    {
        return $this->cssUrlScraper->scrape(implode(PHP_EOL, $this->getStyleBlocksFromMarkup($content)));
    }

    /**
     * Returns the inner content of all <style></style> blocks of the given markup as an array.
     *
     * @param string $content
     * @return array
     */
    private function getStyleBlocksFromMarkup($content)
    {
        $blocks = [];
        $matches = [];

        preg_match_all(
            '~<style[^>]*>(.*?)</style>~is',
            $content,
            $matches,
            PREG_PATTERN_ORDER
        );

        if (is_array($matches) && sizeof($matches) > 1 && is_array($matches[1])) {
            foreach ($matches[1] as $match) {
                // filter inline svg styles
                if (!str_contains($match, 'fill:url')) {
                    $blocks[] = $match;
                }
            }
        }

        return $blocks;
    }
}
