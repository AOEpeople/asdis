<?php
namespace Aoe\Asdis\Content\Scraper\Css;

use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Factory;

/**
 * Scrapes paths from "url()" in CSS.
 */
class Url implements ScraperInterface
{
    /**
     * @var \Aoe\Asdis\Domain\Model\Asset\Factory
     */
    private $assetFactory;

    /**
     * @param \Aoe\Asdis\Domain\Model\Asset\Factory $assetFactory
     */
    public function injectAssetFactory(Factory $assetFactory)
    {
        $this->assetFactory = $assetFactory;
    }

    /**
     * @param $content
     * @return \Aoe\Asdis\Domain\Model\Asset\Collection
     */
    public function scrape($content)
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
        $paths   = [];
        $masks   = [];
        $matches = [];

        preg_match_all(
            '~url\((?!#)\s*([\'"]?)(/?(\.\./)?.*?)([\'"]?);?\s*\)~is',
            $cssContent,
            $matches,
            PREG_PATTERN_ORDER
        );

        if (false === (is_array($matches) && sizeof($matches) > 1 && is_array($matches[2]))) {
            return [
                'paths' => $paths,
                'masks' => $masks
            ];
        }

        foreach ($matches[2] as $mkey => $path) {
            if (strpos($path, ',') !== false) {
                continue;
            }
            $paths[] = $path;
            $masks[] = $matches[1][$mkey];
        }

        return [
            'paths' => $paths,
            'masks' => $masks
        ];
    }
}