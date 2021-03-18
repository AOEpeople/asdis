<?php
namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Html\AbstractHtmlScraper;
use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Factory;

/**
 * Scrapes assets from all tags by using data-src attributes.
 */
class Srcset extends AbstractHtmlScraper implements ScraperInterface
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
     * @param string $content
     * @return \Aoe\Asdis\Domain\Model\Asset\Collection
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
                $paths[] = trim(str_replace(' 2x','', $singlePath));
                $masks[] = '';
            }
        }

        return $this->assetFactory->createAssetsFromPaths($paths, $masks);
    }
}