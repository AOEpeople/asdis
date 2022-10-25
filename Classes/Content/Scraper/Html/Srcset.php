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
    /**
     * @var Factory
     */
    private $assetFactory;

    /**
     * @param Factory $assetFactory
     */
    public function injectAssetFactory(Factory $assetFactory)
    {
        $this->assetFactory = $assetFactory;
    }

    /**
     * @param string $content
     * @return Collection
     */
    public function scrape($content)
    {
        $paths = [];
        $masks = [];
        $matches = [];
        preg_match_all(
            '/srcset=*\s?=\s?([\'"])(.*?)([\'"])/i',
            $content,
            $matches
        );

        foreach ($matches[2] as $mkey => $path) {
            if (strpos($path, ',') === false) {
                $paths[] = $path;
                $masks[] = $matches[1][$mkey];
                continue;
            }

            $expPaths = explode(',', $path);

            foreach ($expPaths as $singlePath) {
                $cleanSinglePath = trim($singlePath);

                if (strpos($cleanSinglePath, ' ') !== false) {
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
