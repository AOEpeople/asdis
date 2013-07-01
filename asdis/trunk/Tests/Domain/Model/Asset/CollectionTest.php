<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
$asdisBaseDir = dirname(__FILE__) . '/../../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/Content/Replacement/Map.php';
require_once $asdisBaseDir . 'Classes/Domain/Model/Asset.php';
require_once $asdisBaseDir . 'Classes/Domain/Model/Asset/Collection.php';
/**
 * Tx_Asdis_Domain_Model_Asset_Collection test case.
 */
class Tx_Asdis_Domain_Model_Asset_CollectionTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @test
	 */
	public function append() {
		$collection = new Tx_Asdis_Domain_Model_Asset_Collection();
		$asset      = new Tx_Asdis_Domain_Model_Asset();
		$collection->append($asset);
		$this->assertEquals(1, $collection->count());
	}

	/**
	 * @test
	 */
	public function appendWithSameOriginalPath() {
		$collection = new Tx_Asdis_Domain_Model_Asset_Collection();
		$asset1     = new Tx_Asdis_Domain_Model_Asset();
		$asset2     = new Tx_Asdis_Domain_Model_Asset();
		$path       = 'uploads/pics/foo.jpg';
		$asset1->setOriginalPath($path);
		$asset2->setOriginalPath($path);
		$collection->append($asset1);
		$collection->append($asset2);
		$this->assertEquals(1, $collection->count());
	}

	/**
	 * @test
	 */
	public function merge() {
		$collection1 = new Tx_Asdis_Domain_Model_Asset_Collection();
		$collection2 = new Tx_Asdis_Domain_Model_Asset_Collection();
		$asset1 = new Tx_Asdis_Domain_Model_Asset();
		$asset2 = new Tx_Asdis_Domain_Model_Asset();
		$asset3 = new Tx_Asdis_Domain_Model_Asset();
		$path1 = 'typo3temp/pics/foo.gif';
		$path2 = 'typo3temp/pics/bar.jpg';
		$path3 = 'typo3temp/pics/hund.png';
		$asset1->setOriginalPath($path1);
		$asset2->setOriginalPath($path2);
		$asset3->setOriginalPath($path3);
		$collection1->append($asset1);
		$collection2->append($asset2);
		$collection2->append($asset3);
		$collection1->merge($collection2);
		$this->assertEquals(3, $collection1->count());
		$this->assertEquals(2, $collection2->count());
	}

	/**
	 * @test
	 */
	public function getReplacementMap() {
		$collection = new Tx_Asdis_Domain_Model_Asset_Collection();
		$asset1 = new Tx_Asdis_Domain_Model_Asset();
		$asset2 = new Tx_Asdis_Domain_Model_Asset();
		$path1 = 'typo3temp/pics/foo.gif';
		$path2 = 'typo3temp/pics/bar.jpg';
		$asset1->setOriginalPath($path1);
		$asset1->setNormalizedPath($path1);
		$asset2->setOriginalPath($path2);
		$asset2->setNormalizedPath($path2);
		$collection->append($asset1);
		$collection->append($asset2);
		$map = $collection->getReplacementMap();
		$this->assertEquals(2, sizeof($map->getSources()));
		$this->assertEquals(2, sizeof($map->getTargets()));
	}
}

