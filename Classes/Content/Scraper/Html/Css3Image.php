<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;

/**
 * Scrapes assets from all tags by using data-src attributes.
 * @see \Aoe\Asdis\Tests\Content\Scraper\Html\Css3ImageTest
 */
class Css3Image extends AbstractHtmlScraper implements ScraperInterface
{
    private Factory $assetFactory;

    public function injectAssetFactory(Factory $assetFactory): void
    {
        $this->assetFactory = $assetFactory;
    }

    public function scrape(string $content): ?Collection
    {
        $paths = [];
        $masks = [];
        $matches = [];
        preg_match_all(
            '/data-src-[^=]*\s?=\s?([\'"])(.*?)([\'"])/i',
            $content,
            $matches
        );
        if (is_array($matches) && count($matches) > 1 && is_array($matches[2])) {
            $paths = $matches[2];
            $masks = $matches[1];
        }

        return $this->assetFactory->createAssetsFromPaths($paths, $masks);
    }
}
