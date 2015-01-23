<?php

/**
 * Factory which builds asset objects and collections.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Model_Asset
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Domain_Model_Asset_Factory {

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * @var Tx_Asdis_System_Uri_Normalizer
	 */
	private $uriNormalizer;

	/**
	 * @var Tx_Asdis_System_Uri_Filter_Chain
	 */
	private $filterChain;

	/**
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * @param Tx_Asdis_System_Uri_Normalizer $uriNormalizer
	 */
	public function injectUriNormalizer(Tx_Asdis_System_Uri_Normalizer $uriNormalizer) {
		$this->uriNormalizer = $uriNormalizer;
	}

	/**
	 * @param Tx_Asdis_System_Uri_Filter_ChainFactory $filterChainFactory
	 */
	public function injectFilterChainFactory(Tx_Asdis_System_Uri_Filter_ChainFactory $filterChainFactory) {
		$this->filterChain = $filterChainFactory->buildChain();
	}

	/**
	 * @param array $paths Array of path strings.
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function createAssetsFromPaths(array $paths) {
		$paths  = $this->filterChain->filter($paths);
		$assets = $this->createAssetCollection();
		foreach ($paths as $path) {
			$assets->append($this->createAssetFromPath($path));
		}
		return $assets;
	}

	/**
	 * @param $path
	 * @return Tx_Asdis_Domain_Model_Asset
	 */
	protected function createAssetFromPath($path) {
		$asset = $this->createAsset();
		$asset->setOriginalPath($path);
		$asset->setNormalizedPath($this->getNormalizedPath($path));
		return $asset;
	}

	/**
	 * @return Tx_Asdis_Domain_Model_Asset
	 */
	protected function createAsset() {
		return $this->objectManager->get('Tx_Asdis_Domain_Model_Asset');
	}

	/**
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	protected function createAssetCollection() {
		return $this->objectManager->get('Tx_Asdis_Domain_Model_Asset_Collection');
	}

	/**
	 * @param string $originalPath
	 * @return string
	 */
	private function getNormalizedPath($originalPath) {
		return $this->uriNormalizer->normalizePath($originalPath);
	}
}