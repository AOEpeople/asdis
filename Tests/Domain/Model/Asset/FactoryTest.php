<?php

/**
 * Tx_Asdis_Domain_Model_Asset_Factory test case.
 */
class Tx_Asdis_Domain_Model_Asset_FactoryTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @test
	 */
	public function createAssetsFromPaths() {
		$path = 'uploads/images/foo.jpg';
		$mask = '"';
		$assetFactory = $this->getMock('Tx_Asdis_Domain_Model_Asset_Factory', array('createAsset', 'createAssetCollection'));
		$assetFactory->expects($this->once())->method('createAssetCollection')->will($this->returnValue(new Tx_Asdis_Domain_Model_Asset_Collection()));
		$assetFactory->expects($this->once())->method('createAsset')->will($this->returnValue(new Tx_Asdis_Domain_Model_Asset()));
		$filterChainFactoryMock = $this->getMock('Tx_Asdis_System_Uri_Filter_ChainFactory', array('buildChain'));
		$filterChainFactoryMock->expects($this->once())->method('buildChain')->will($this->returnValue(new Tx_Asdis_System_Uri_Filter_Chain()));
		$assetFactory->injectFilterChainFactory($filterChainFactoryMock);
		$assetFactory->injectUriNormalizer(new Tx_Asdis_System_Uri_Normalizer());
		$assets = $assetFactory->createAssetsFromPaths(array($path), array($mask));
		$this->assertEquals(1, $assets->count());
	}

	/**
	 * @test
	 */
	public function createAssetsFromPathsAndFilter() {
		$paths = array('uploads/images/foo.jpg', 'fileadmin/images/bar.jpg', 'uploads/images/blub.jpg');
		$masks = array('"', '\'', '"');
		$filteredPaths = array('uploads/images/foo.jpg', 'uploads/images/blub.jpg');

		$assetFactory = $this->getMock('Tx_Asdis_Domain_Model_Asset_Factory', array('createAsset', 'createAssetCollection'));
		$assetFactory->expects($this->once())->method('createAssetCollection')->will($this->returnValue(new Tx_Asdis_Domain_Model_Asset_Collection()));
		$assetFactory->expects($this->exactly(2))->method('createAsset')->will($this->returnValue(new Tx_Asdis_Domain_Model_Asset()));
		$filterChainMock = $this->getMock('Tx_Asdis_System_Uri_Filter_Chain', array('filter'));
		$filterChainMock->expects($this->once())->method('filter')->will($this->returnValue($filteredPaths));
		$filterChainFactoryMock = $this->getMock('Tx_Asdis_System_Uri_Filter_ChainFactory', array('buildChain'));
		$filterChainFactoryMock->expects($this->once())->method('buildChain')->will($this->returnValue($filterChainMock));
		$assetFactory->injectFilterChainFactory($filterChainFactoryMock);
		$assetFactory->injectUriNormalizer(new Tx_Asdis_System_Uri_Normalizer());
		$assets = $assetFactory->createAssetsFromPaths($paths, $masks);
		$this->assertEquals(2, $assets->count());
	}

}

