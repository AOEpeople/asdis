<?php

namespace Aoe\Asdis\Tests\Domain\Model;

use Aoe\Asdis\Domain\Model\Server;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ServerTest extends UnitTestCase
{
    private Server $server;

    private string $domain = 'media1.foo.com';

    protected function setUp(): void
    {
        parent::setUp();

        $this->server = new Server();
    }

    public function testSetAndGetDomain(): void
    {
        $this->server->setDomain($this->domain);
        $this->assertSame($this->domain, $this->server->getDomain());
    }

    public function testSetAndGetIdentifier(): void
    {
        $identifier = 'media1';
        $this->server->setIdentifier($identifier);
        $this->assertSame($identifier, $this->server->getIdentifier());
    }

    public function testSetAndGetProtocol(): void
    {
        $invalidProtocol = 'fancy';
        $this->server->setProtocol($invalidProtocol);
        $this->assertNotSame($invalidProtocol, $this->server->getProtocol());

        $this->server->setProtocol(Server::PROTOCOL_DYNAMIC);
        $this->assertSame(Server::PROTOCOL_DYNAMIC, $this->server->getProtocol());

        $this->server->setProtocol(Server::PROTOCOL_MARKER);
        $this->assertSame(Server::PROTOCOL_MARKER, $this->server->getProtocol());

        $this->server->setProtocol(Server::PROTOCOL_WILDCARD);
        $this->assertSame(Server::PROTOCOL_WILDCARD, $this->server->getProtocol());

        $this->server->setProtocol(Server::PROTOCOL_HTTP);
        $this->assertSame(Server::PROTOCOL_HTTP, $this->server->getProtocol());

        $this->server->setProtocol(Server::PROTOCOL_HTTPS);
        $this->assertSame(Server::PROTOCOL_HTTPS, $this->server->getProtocol());
    }

    public function testGetUriWithMarker(): void
    {
        $marker = '###HTTP_S###';
        $this->server->setDomain($this->domain);
        $this->server->setProtocolMarker($marker);
        $this->server->setProtocol(Server::PROTOCOL_MARKER);
        $this->assertSame($marker . $this->domain . '/', $this->server->getUri());
    }

    public function testGetUriWithWildcard(): void
    {
        $this->server->setDomain($this->domain);
        $this->server->setProtocol(Server::PROTOCOL_WILDCARD);
        $this->assertSame('//' . $this->domain . '/', $this->server->getUri());
    }

    public function testGetUriWithHttp(): void
    {
        $this->server->setDomain($this->domain);
        $this->server->setProtocol(Server::PROTOCOL_HTTP);
        $this->assertSame('http://' . $this->domain . '/', $this->server->getUri());
    }

    public function testGetUriWithHttps(): void
    {
        $this->server->setDomain($this->domain);
        $this->server->setProtocol(Server::PROTOCOL_HTTPS);
        $this->assertSame('https://' . $this->domain . '/', $this->server->getUri());
    }
}
