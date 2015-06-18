<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
$asdisBaseDir = dirname(__FILE__) . '/../../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/Domain/Model/Asset.php';
require_once $asdisBaseDir . 'Classes/Domain/Model/Asset/Collection.php';
require_once $asdisBaseDir . 'Classes/Domain/Model/Asset/Factory.php';
require_once $asdisBaseDir . 'Classes/System/Uri/Filter/Chain.php';
require_once $asdisBaseDir . 'Classes/System/Uri/Filter/ChainFactory.php';
require_once $asdisBaseDir . 'Classes/System/Uri/Normalizer.php';
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
}

