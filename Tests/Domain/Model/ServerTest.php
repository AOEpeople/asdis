<?php
namespace Aoe\Asdis\Tests\Domain\Model;

use Aoe\Asdis\Domain\Model\Server;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class ServerTest extends UnitTestCase
{
    /**
     * @var Server
     */
    private $server;

    /**
     * @var string
     */
    private $domain = 'media1.foo.com';

    /**
     * (non-PHPdoc)
     */
    protected function setUp(): void
    {
        $this->server = new Server();
    }

    /**
     * @test
     */
    public function setAndGetDomain()
    {
        $this->server->setDomain($this->domain);
        $this->assertEquals($this->domain, $this->server->getDomain());
    }

    /**
     * @test
     */
    public function setAndGetIdentifier()
    {
        $identifier = 'media1';
        $this->server->setIdentifier($identifier);
        $this->assertEquals($identifier, $this->server->getIdentifier());
    }

    /**
     * @test
     */
    public function setAndGetProtocol()
    {
        $invalidProtocol = 'fancy';
        $this->server->setProtocol($invalidProtocol);
        $this->assertNotEquals($invalidProtocol, $this->server->getProtocol());

        $this->server->setProtocol(Server::PROTOCOL_DYNAMIC);
        $this->assertEquals(Server::PROTOCOL_DYNAMIC, $this->server->getProtocol());

        $this->server->setProtocol(Server::PROTOCOL_MARKER);
        $this->assertEquals(Server::PROTOCOL_MARKER, $this->server->getProtocol());

        $this->server->setProtocol(Server::PROTOCOL_WILDCARD);
        $this->assertEquals(Server::PROTOCOL_WILDCARD, $this->server->getProtocol());

        $this->server->setProtocol(Server::PROTOCOL_HTTP);
        $this->assertEquals(Server::PROTOCOL_HTTP, $this->server->getProtocol());

        $this->server->setProtocol(Server::PROTOCOL_HTTPS);
        $this->assertEquals(Server::PROTOCOL_HTTPS, $this->server->getProtocol());
    }

    /**
     * @test
     */
    public function getUriWithMarker()
    {
        $marker = '###HTTP_S###';
        $this->server->setDomain($this->domain);
        $this->server->setProtocolMarker($marker);
        $this->server->setProtocol(Server::PROTOCOL_MARKER);
        $this->assertEquals($marker . $this->domain . '/', $this->server->getUri());
    }

    /**
     * @test
     */
    public function getUriWithWildcard()
    {
        $this->server->setDomain($this->domain);
        $this->server->setProtocol(Server::PROTOCOL_WILDCARD);
        $this->assertEquals('//' . $this->domain . '/', $this->server->getUri());
    }

    /**
     * @test
     */
    public function getUriWithHttp()
    {
        $this->server->setDomain($this->domain);
        $this->server->setProtocol(Server::PROTOCOL_HTTP);
        $this->assertEquals('http://' . $this->domain . '/', $this->server->getUri());
    }

    /**
     * @test
     */
    public function getUriWithHttps()
    {
        $this->server->setDomain($this->domain);
        $this->server->setProtocol(Server::PROTOCOL_HTTPS);
        $this->assertEquals('https://' . $this->domain . '/', $this->server->getUri());
    }
}

