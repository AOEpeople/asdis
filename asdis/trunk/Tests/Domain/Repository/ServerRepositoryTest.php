<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
require_once dirname(__FILE__).'/../../../Classes/Domain/Repository/ServerRepository.php';
require_once dirname(__FILE__).'/../../../Tests/AbstractTestcase.php';
/**
 * Tx_Asdis_Domain_Repository_ServerRepository test case.
 */
class Tx_Asdis_Domain_Repository_ServerRepositoryTest extends Tx_Asdis_Tests_AbstractTestcase {
	/**
	 * @var Tx_Asdis_Domain_Repository_ServerRepository
	 */
	private $serverRepository;
	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->serverRepository = new Tx_Asdis_Domain_Repository_ServerRepository();
	}
	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$this->serverRepository = null;
	}
	/**
	 * Tests Tx_Asdis_Domain_Repository_ServerRepository->findAllByPage()
	 * @test
	 */
	public function findAllByPage() {
		$objectManager = $this->getMock('Tx_Extbase_Object_ObjectManagerInterface');
		$objectManager->expects($this->any())->method('create')->will($this->returnValue($this->getMock('Tx_Asdis_Domain_Model_Server_Collection')));
		$this->serverRepository->injectObjectManager($objectManager);
		$this->serverRepository->injectServerFactory($this->getMock('Tx_Asdis_Domain_Model_Server_Factory'));
		$this->serverRepository->injectConfigurationProvider($this->getMock('Tx_Asdis_System_Configuration_Provider'));
		$test = $this->serverRepository->findAllByPage($this->getMock('Tx_Asdis_Domain_Model_Page'));
		$this->assertTrue($test instanceof Tx_Asdis_Domain_Model_Server_Collection);
	}
}

