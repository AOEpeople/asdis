<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
$asdisBaseDir = dirname(__FILE__) . '/../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/Domain/Model/Asset.php';
require_once $asdisBaseDir . 'Classes/Domain/Model/Server.php';
/**
 * Tx_Asdis_Domain_Model_Asset test case.
 */
class Tx_Asdis_Domain_Model_AssetTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_Domain_Model_Asset
	 */
	private $asset;
	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->asset = new Tx_Asdis_Domain_Model_Asset();

	}
	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$this->asset = NULL;

	}

	/**
	 * @test
	 */
	public function setAndGetOriginalPath() {
		$path = 'typo3temp/pics/foo-gif';
		$this->asset->setOriginalPath($path);
		$this->assertEquals($path, $this->asset->getOriginalPath());
	}

	/**
	 * @test
	 */
	public function setAndGetNormalizedPath() {
		$path = 'uploads/img/bar.png';
		$this->asset->setNormalizedPath($path);
		$this->assertEquals($path, $this->asset->getNormalizedPath());
	}

	/**
	 * @test
	 */
	public function getPregQuotedOriginalPath() {
		$path = 'uploads/images/baz.jpg';
		$this->asset->setOriginalPath($path);
		$this->assertEquals('~/?uploads/images/baz\.jpg~is', $this->asset->getPregQuotedOriginalPath());
	}

	/**
	 * @test
	 */
	public function setAndGetServer() {
		$server = new Tx_Asdis_Domain_Model_Server();
		$server->setIdentifier('media1');
		$this->asset->setServer($server);
		$this->assertEquals('media1', $this->asset->getServer()->getIdentifier());
	}

	/**
	 * @test
	 */
	public function getUri() {
		$baseUri = 'http://www.foo.com/';
		$path = 'uploads/images/foo.jpg';
		$server = $this->getMock('Tx_Asdis_Domain_Model_Server', array('getUri'));
		$server->expects($this->once())->method('getUri')->will($this->returnValue($baseUri));
		$this->asset->setNormalizedPath($path);
		$this->asset->setServer($server);
		$this->assertEquals($baseUri . $path, $this->asset->getUri());
	}
}

