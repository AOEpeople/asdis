<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
$asdisBaseDir = dirname(__FILE__) . '/../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/Domain/Model/Server.php';
/**
 * Tx_Asdis_Domain_Model_Server test case.
 */
class Tx_Asdis_Domain_Model_ServerTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_Domain_Model_Server
	 */
	private $server;

	/**
	 * @var string
	 */
	private $domain = 'media1.foo.com';

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->server = new Tx_Asdis_Domain_Model_Server();

	}

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$this->server = NULL;
	}

	/**
	 * @test
	 */
	public function setAndGetDomain() {
		$this->server->setDomain($this->domain);
		$this->assertEquals($this->domain, $this->server->getDomain());
	}

	/**
	 * @test
	 */
	public function setAndGetIdentifier() {
		$identifier = 'media1';
		$this->server->setIdentifier($identifier);
		$this->assertEquals($identifier, $this->server->getIdentifier());
	}

	/**
	 * @test
	 */
	public function setAndGetProtocol() {
		$invalidProtocol = 'fancy';
		$this->server->setProtocol($invalidProtocol);
		$this->assertNotEquals($invalidProtocol, $this->server->getProtocol());

		$this->server->setProtocol(Tx_Asdis_Domain_Model_Server::PROTOCOL_DYNAMIC);
		$this->assertEquals(Tx_Asdis_Domain_Model_Server::PROTOCOL_DYNAMIC, $this->server->getProtocol());

		$this->server->setProtocol(Tx_Asdis_Domain_Model_Server::PROTOCOL_MARKER);
		$this->assertEquals(Tx_Asdis_Domain_Model_Server::PROTOCOL_MARKER, $this->server->getProtocol());

		$this->server->setProtocol(Tx_Asdis_Domain_Model_Server::PROTOCOL_WILDCARD);
		$this->assertEquals(Tx_Asdis_Domain_Model_Server::PROTOCOL_WILDCARD, $this->server->getProtocol());

		$this->server->setProtocol(Tx_Asdis_Domain_Model_Server::PROTOCOL_HTTP);
		$this->assertEquals(Tx_Asdis_Domain_Model_Server::PROTOCOL_HTTP, $this->server->getProtocol());

		$this->server->setProtocol(Tx_Asdis_Domain_Model_Server::PROTOCOL_HTTPS);
		$this->assertEquals(Tx_Asdis_Domain_Model_Server::PROTOCOL_HTTPS, $this->server->getProtocol());
	}

	/**
	 * @test
	 */
	public function getUriWithMarker() {
		$marker = '###HTTP_S###';
		$this->server->setDomain($this->domain);
		$this->server->setProtocolMarker($marker);
		$this->server->setProtocol(Tx_Asdis_Domain_Model_Server::PROTOCOL_MARKER);
		$this->assertEquals($marker . $this->domain . '/', $this->server->getUri());
	}

	/**
	 * @test
	 */
	public function getUriWithWildcard() {
		$this->server->setDomain($this->domain);
		$this->server->setProtocol(Tx_Asdis_Domain_Model_Server::PROTOCOL_WILDCARD);
		$this->assertEquals('//' . $this->domain . '/', $this->server->getUri());
	}

	/**
	 * @test
	 */
	public function getUriWithHttp() {
		$this->server->setDomain($this->domain);
		$this->server->setProtocol(Tx_Asdis_Domain_Model_Server::PROTOCOL_HTTP);
		$this->assertEquals('http://' . $this->domain . '/', $this->server->getUri());
	}

	/**
	 * @test
	 */
	public function getUriWithHttps() {
		$this->server->setDomain($this->domain);
		$this->server->setProtocol(Tx_Asdis_Domain_Model_Server::PROTOCOL_HTTPS);
		$this->assertEquals('https://' . $this->domain . '/', $this->server->getUri());
	}
}

