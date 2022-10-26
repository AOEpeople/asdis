<?php

namespace Aoe\Asdis\Content\Scraper\Html;

use Aoe\Asdis\Content\Scraper\Extractor\XmlTagAttribute;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\Domain\Model\Asset\Factory;

/**
 * Abstract scraper which provides general functionality to scrape paths from HTML tag attributes.
 */
abstract class AbstractHtmlScraper
{
    private ?XmlTagAttribute $xmlTagAttributeExtractor = null;
    private ?Factory $assetFactory = null;

    public function injectXmlTagAttributeExtractor(XmlTagAttribute $xmlTagAttributeExtractor): void
    {
        $this->xmlTagAttributeExtractor = $xmlTagAttributeExtractor;
    }

    public function injectAssetFactory(Factory $assetFactory): void
    {
        $this->assetFactory = $assetFactory;
    }

    protected function getAssets(string $tagName, string $attributeName, string $content, array $requiredOtherAttributes = []): ?Collection
    {
        $attributes = $this->xmlTagAttributeExtractor->getAttributeFromTag(
            $tagName,
            $attributeName,
            $content,
            $requiredOtherAttributes
        );
        return $this->assetFactory->createAssetsFromPaths(
            $attributes['paths'],
            $attributes['masks']
        );
    }
}
