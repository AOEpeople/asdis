<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
$asdisBaseDir = dirname(__FILE__) . '/../../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/Domain/Model/Server.php';
require_once $asdisBaseDir . 'Classes/Domain/Model/Server/Factory.php';
require_once $asdisBaseDir . 'Classes/System/Configuration/Provider.php';
/**
 * Tx_Asdis_Domain_Model_Server_Factory test case.
 */
class Tx_Asdis_Domain_Model_Server_FactoryTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @test
	 */
	public function createServer() {
		$factory = new Tx_Asdis_Domain_Model_Server_Factory();
		$protocolMarker = '###HTTP_S###';
		$identifier = 'media1';
		$domain = 'media1.foo.com';
		$protocol = Tx_Asdis_Domain_Model_Server::PROTOCOL_MARKER;
		$blankServer = new Tx_Asdis_Domain_Model_Server();
		$objectManagerMock = $this->getMock('Tx_Extbase_Object_ObjectManager', array('get'));
		$objectManagerMock->expects($this->once())->method('get')->will($this->returnValue($blankServer));
		$configurationProviderMock = $this->getMock('Tx_Asdis_System_Configuration_Provider', array('getServerProtocolMarker'));
		$configurationProviderMock->expects($this->once())->method('getServerProtocolMarker')->will($this->returnValue($protocolMarker));
		$factory->injectObjectManager($objectManagerMock);
		$factory->injectConfigurationProvider($configurationProviderMock);
		$server = $factory->createServer($identifier, $domain, $protocol);
		$this->assertEquals($identifier, $server->getIdentifier());
		$this->assertEquals($domain, $server->getDomain());
		$this->assertEquals($protocol, $server->getProtocol());
	}
}

