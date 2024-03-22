<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Css\Url;
use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;

/**
 * Scrapes assets from inline CSS.
 * @see \Aoe\Asdis\Tests\Content\Scraper\Html\CssInlineTest
 */
class CssInline implements ScraperInterface
{
    private ?Url $cssUrlScraper = null;

    public function injectCssUrlScraper(Url $cssUrlScraper): void
    {
        $this->cssUrlScraper = $cssUrlScraper;
    }

    public function scrape(string $content): ?Collection
    {
        return $this->cssUrlScraper->scrape(implode(PHP_EOL, $this->getStyleBlocksFromMarkup($content)));
    }

    /**
     * Returns the inner content of all <style></style> blocks of the given markup as an array.
     */
    private function getStyleBlocksFromMarkup(string $content): array
    {
        $blocks = [];
        $matches = [];

        preg_match_all(
            '~<style[^>]*>(.*?)</style>~is',
            $content,
            $matches,
            PREG_PATTERN_ORDER
        );

        if (is_array($matches) && count($matches) > 1 && is_array($matches[1])) {
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
