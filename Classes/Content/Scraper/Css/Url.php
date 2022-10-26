<?php

namespace Aoe\Asdis\Content\Scraper\Css;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;

/**
 * Scrapes paths from "url()" in CSS.
 */
class Url implements ScraperInterface
{
    private ?Factory $assetFactory = null;

    public function injectAssetFactory(Factory $assetFactory): void
    {
        $this->assetFactory = $assetFactory;
    }

    public function scrape(string $content): ?Collection
    {
        $urls = $this->extractUrlPaths($content);
        return $this->assetFactory->createAssetsFromPaths($urls['paths'], $urls['masks']);
    }

    /**
     * Extracts paths to resources in CSS code.
     * This means file references which are included in "url(...)".
     *
     * @param string $cssContent
     * @return array
     */
    private function extractUrlPaths($cssContent)
    {
        $paths = [];
        $masks = [];
        $matches = [];

        preg_match_all(
            '~url\((?!#)\s*([\'"]?)(/?(\.\./)?.*?)([\'"]?);?\s*\)~is',
            $cssContent,
            $matches,
            PREG_PATTERN_ORDER
        );

        if (!(is_array($matches) && count($matches) > 1 && is_array($matches[2]))) {
            return [
                'paths' => $paths,
                'masks' => $masks,
            ];
        }

        foreach ($matches[2] as $mkey => $path) {
            if (str_contains($path, ',')) {
                continue;
            }
            $paths[] = $path;
            $masks[] = $matches[1][$mkey];
        }

        return [
            'paths' => $paths,
            'masks' => $masks,
        ];
    }
}
