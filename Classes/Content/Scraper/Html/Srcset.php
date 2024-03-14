<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;

/**
 * Scrapes assets from all tags by using data-src attributes.
 */
class Srcset extends AbstractHtmlScraper implements ScraperInterface
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
            '/srcset=*\s?=\s?([\'"])(.*?)([\'"])/is',
            $content,
            $matches
        );

        foreach ($matches[2] as $mkey => $path) {
            if (!str_contains($path, ',')) {
                $paths[] = $path;
                $masks[] = $matches[1][$mkey];
                continue;
            }

            $expPaths = explode(',', $path);

            foreach ($expPaths as $singlePath) {
                $cleanSinglePath = trim($singlePath);

                if (str_contains($cleanSinglePath, ' ')) {
                    $paths[] = substr($cleanSinglePath, 0, strpos($cleanSinglePath, ' '));
                } else {
                    $paths[] = $cleanSinglePath;
                }

                $masks[] = '';
            }
        }

        return $this->assetFactory->createAssetsFromPaths($paths, $masks);
    }
}
