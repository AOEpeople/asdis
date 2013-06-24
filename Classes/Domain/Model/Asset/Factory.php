<?php

class Tx_Asdis_Domain_Model_Asset_Factory {

	/**
	 * @var Tx_Asdis_Uri_NormalizationService
	 */
	private $uriNormalizationService;

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
		$asset = new Tx_Asdis_Domain_Model_Asset();
		$asset->setOriginalPath($path);
		$asset->setRelativePath($this->getNormalizedPath($path));
		return $asset;
	}

	/**
	 * @param array $paths
	 * @return Tx_Asdis_Domain_Model_Asset_Collection
	 */
	public function createAssetsFromPaths(array $paths) {
		$assets = new Tx_Asdis_Domain_Model_Asset_Collection();
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