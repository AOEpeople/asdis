<?php

namespace Aoe\Asdis\Tests\Domain\Model\Server;

use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\Domain\Model\Server\Factory;
use Aoe\Asdis\System\Configuration\Provider;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class FactoryTest extends UnitTestCase
{
    public function testCreateServer(): void
    {
        $factory = new Factory();
        $protocolMarker = '###HTTP_S###';
        $identifier = 'media1';
        $domain = 'media1.foo.com';
        $protocol = Server::PROTOCOL_MARKER;

        $configurationProvider = $this->getMockBuilder(Provider::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getServerProtocolMarker'])
            ->getMock();

        $configurationProvider
            ->expects($this->once())
            ->method('getServerProtocolMarker')
            ->willReturn($protocolMarker);

        $factory->injectConfigurationProvider($configurationProvider);

        $server = $factory->createServer($identifier, $domain, $protocol);

        $this->assertSame($identifier, $server->getIdentifier());
        $this->assertSame($domain, $server->getDomain());
        $this->assertSame($protocol, $server->getProtocol());
    }
}
