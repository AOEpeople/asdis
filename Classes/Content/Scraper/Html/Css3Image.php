<?php
namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Html\AbstractHtmlScraper;
use Aoe\Asdis\Content\Scraper\ScraperInterface;
use Aoe\Asdis\Domain\Model\Asset\Factory;

/**
 * Scrapes assets from all tags by using data-src attributes.
 */
class Css3Image extends AbstractHtmlScraper implements ScraperInterface
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
            '/data-src-[^=]*\s?=\s?([\'"])(.*?)([\'"])/i',
            $content,
            $matches
        );
        if (is_array($matches) && sizeof($matches) > 1 && is_array($matches[2])) {
            $paths = $matches[2];
            $masks = $matches[1];
        }
        return $this->assetFactory->createAssetsFromPaths($paths, $masks);
    }
}