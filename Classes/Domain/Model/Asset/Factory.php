<?php

namespace Aoe\Asdis\Domain\Model\Asset;

use Aoe\Asdis\Domain\Model\Asset;
use Aoe\Asdis\Domain\Model\Asset\Collection as AssetCollection;
use Aoe\Asdis\System\Uri\Filter\Chain;
use Aoe\Asdis\System\Uri\Normalizer;
use Aoe\Asdis\System\Uri\Filter\ChainFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Factory which builds asset objects and collections.
 */
class Factory
{
    private ?Normalizer $uriNormalizer = null;

    private ?Chain $filterChain = null;

    public function injectUriNormalizer(Normalizer $uriNormalizer): void
    {
        $this->uriNormalizer = $uriNormalizer;
    }

    public function injectFilterChainFactory(ChainFactory $filterChainFactory): void
    {
        $this->filterChain = $filterChainFactory->buildChain();
    }

    /**
     * @param array $paths Array of path strings.
     * @param array $masks Array of mask strings.
     */
    public function createAssetsFromPaths(array $paths, array $masks): Collection
    {
        $filteredPaths = $this->filterChain->filter($paths);
        $paths = array_intersect($paths, $filteredPaths);
        $masks = array_intersect_key($masks, $paths);

        $assets = $this->createAssetCollection();
        foreach ($paths as $key => $path) {
            $assets->append($this->createAssetFromPath($path, $masks[$key]));
        }
        return $assets;
    }

    protected function createAssetFromPath(string $path, string $mask): Asset
    {
        $asset = $this->createAsset();
        $asset->setOriginalPath($path);
        $asset->setMask($mask);
        $asset->setNormalizedPath($this->getNormalizedPath($path));
        return $asset;
    }

    protected function createAsset(): Asset
    {
        return GeneralUtility::makeInstance(Asset::class);
    }

    protected function createAssetCollection(): Collection
    {
        return GeneralUtility::makeInstance(AssetCollection::class);
    }

    private function getNormalizedPath(string $originalPath): string
    {
        return $this->uriNormalizer->normalizePath($originalPath);
    }
}
