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
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	private $objectManager;

	/**
	 * @var Tx_Asdis_Uri_NormalizationService
	 */
	private $uriNormalizationService;

	/**
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * @param Tx_Asdis_Uri_NormalizationService $uriNormalizationService
	 */
	public function injectUriNormalizationService(Tx_Asdis_Uri_NormalizationService $uriNormalizationService) {
		$this->uriNormalizationService = $uriNormalizationService;
	}

	/**
	 * @param $path
	 * @return Tx_Asdis_Domain_Model_Asset
	 */
	public function createAssetFromPath($path) {
		/** @var Tx_Asdis_Domain_Model_Asset $asset */
		$asset = $this->objectManager->create('Tx_Asdis_Domain_Model_Asset');
		$asset->setOriginalPath($path);
		$asset->setRelativePath($this->getNormalizedPath($path));
		return $asset;
	}

	/**
	 * @param array $paths
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function createAssetsFromPaths(array $paths) {
		/** @var Tx_Asdis_Domain_Model_Asset_Collection $assets */
		$assets = $this->objectManager->create('Tx_Asdis_Domain_Model_Asset_Collection');
		foreach($paths as $path) {
			$assets->append($this->createAssetFromPath($path));
		}
		return $assets;
	}

	/**
	 * @param $originalPath
	 */
	private function getNormalizedPath($originalPath) {
		return $this->uriNormalizationService->normalizePath($originalPath);
	}
}