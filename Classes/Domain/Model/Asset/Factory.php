<?php
namespace Aoe\Asdis\Domain\Model\Asset;

use Aoe\Asdis\Domain\Model\Asset;
use Aoe\Asdis\Domain\Model\Asset\Collection as AssetCollection;
use Aoe\Asdis\System\Uri\Normalizer;
use Aoe\Asdis\System\Uri\Filter\Chain;
use Aoe\Asdis\System\Uri\Filter\ChainFactory;

/**
 * Factory which builds asset objects and collections.
 */
class Factory
{
    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var \Aoe\Asdis\System\Uri\Normalizer
     */
    private $uriNormalizer;

    /**
     * @var \Aoe\Asdis\System\Uri\Filter\Chain
     */
    private $filterChain;

    /**
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param \Aoe\Asdis\System\Uri\Normalizer $uriNormalizer
     */
    public function injectUriNormalizer(Normalizer $uriNormalizer)
    {
        $this->uriNormalizer = $uriNormalizer;
    }

    /**
     * @param Aoe\Asdis\System\Uri\Filter\ChainFactory $filterChainFactory
     */
    public function injectFilterChainFactory(ChainFactory $filterChainFactory)
    {
        $this->filterChain = $filterChainFactory->buildChain();
    }

    /**
     * @param array $paths Array of path strings.
     * @param array $masks Array of mask strings.
     * @return \Aoe\Asdis\Domain\Model\Asset\Collection
     */
    public function createAssetsFromPaths(array $paths, array $masks)
    {
        $filteredPaths  = $this->filterChain->filter($paths);
        $paths = array_intersect($paths, $filteredPaths);
        $masks = array_intersect_key($masks, $paths);

        $assets = $this->createAssetCollection();
        foreach ($paths as $key => $path) {
            $assets->append($this->createAssetFromPath($path, $masks[$key]));
        }
        return $assets;
    }

    /**
     * @param string $path
     * @param string $mask
     * @return \Aoe\Asdis\Domain\Model\Asset
     */
    protected function createAssetFromPath($path, $mask)
    {
        $asset = $this->createAsset();
        $asset->setOriginalPath($path);
        $asset->setMask($mask);
        $asset->setNormalizedPath($this->getNormalizedPath($path));
        return $asset;
    }

    /**
     * @return \Aoe\Asdis\Domain\Model\Asset
     */
    protected function createAsset() {
        return $this->objectManager->get(Asset::class);
    }

    /**
     * @return \Aoe\Asdis\Domain\Model\Asset\Collection
     */
    protected function createAssetCollection() {
        return $this->objectManager->get(AssetCollection::class);
    }

    /**
     * @param string $originalPath
     * @return string
     */
    private function getNormalizedPath($originalPath) {
        return $this->uriNormalizer->normalizePath($originalPath);
    }
}