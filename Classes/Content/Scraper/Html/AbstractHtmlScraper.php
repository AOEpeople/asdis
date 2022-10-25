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
    /**
     * @var XmlTagAttribute
     */
    private $xmlTagAttributeExtractor;

    /**
     * @var Factory
     */
    private $assetFactory;

    /**
     * @param XmlTagAttribute $xmlTagAttributeExtractor
     */
    public function injectXmlTagAttributeExtractor(XmlTagAttribute $xmlTagAttributeExtractor)
    {
        $this->xmlTagAttributeExtractor = $xmlTagAttributeExtractor;
    }

    /**
     * @param Factory $assetFactory
     */
    public function injectAssetFactory(Factory $assetFactory)
    {
        $this->assetFactory = $assetFactory;
    }

    /**
     * @param string $tagName
     * @param string $attributeName
     * @param string $content
     * @param array $requiredOtherAttributes
     * @return Collection
     */
    protected function getAssets($tagName, $attributeName, $content, array $requiredOtherAttributes = [])
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
