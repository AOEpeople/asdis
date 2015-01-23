<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
require_once dirname(__FILE__).'/../../../Classes/Domain/Repository/ServerRepository.php';
require_once dirname(__FILE__).'/../../../Classes/Domain/Model/Page.php';
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
		$this->serverRepository = NULL;
	}
	/**
	 * Tests Tx_Asdis_Domain_Repository_ServerRepository->findAll()
	 * @test
	 */
	public function findAllByPage() {
		$objectManager = $this->getMock('Tx_Extbase_Object_ObjectManagerInterface');
		$objectManager->expects($this->any())->method('get')->will($this->returnValue($this->getMock('Tx_Asdis_Domain_Model_Server_Collection')));
		$this->serverRepository->injectObjectManager($objectManager);
		$page = new Tx_Asdis_Domain_Model_Page();
		$server = array();
		$server['identifier']= uniqid();
		$server['domain']= 'example.com';
		$servers = array($server);
		$config = $this->getMock('Tx_Asdis_System_Configuration_Provider');
		$config->expects($this->any())->method('getServerDefinitions')->will($this->returnValue($servers));
		$this->serverRepository->injectConfigurationProvider($config);
		$factory = $this->getMock('Tx_Asdis_Domain_Model_Server_Factory');
		$factory->expects($this->once())->method('createServer')->will($this->returnValue($this->getMock('Tx_Asdis_Domain_Model_Server')));
		$this->serverRepository->injectServerFactory($factory);
		$test = $this->serverRepository->findAllByPage($page);
		$this->assertTrue($test instanceof Tx_Asdis_Domain_Model_Server_Collection);
	}
}

