<?php
namespace Aoe\Asdis\Tests\Domain\Model\Server;

use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\Domain\Model\Server\Factory;
use Aoe\Asdis\System\Configuration\Provider;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

class FactoryTest extends UnitTestCase
{
    /**
     * @test
     */
    public function createServer()
    {
        $factory = new Factory();
        $protocolMarker = '###HTTP_S###';
        $identifier = 'media1';
        $domain = 'media1.foo.com';
        $protocol = Server::PROTOCOL_MARKER;
        $blankServer = new Server();

        $objectManagerMock = $this->getMockBuilder(ObjectManagerInterface::class)->getMock();
        $objectManagerMock->expects($this->once())->method('get')->will($this->returnValue($blankServer));

        $configurationProvider = $this->getMockBuilder(Provider::class)
            ->setMethods(['getServerProtocolMarker'])
            ->getMock();
            
        $configurationProvider
            ->expects($this->once())
            ->method('getServerProtocolMarker')
            ->will($this->returnValue($protocolMarker));

        $factory->injectObjectManager($objectManagerMock);
        $factory->injectConfigurationProvider($configurationProvider);

        $server = $factory->createServer($identifier, $domain, $protocol);
        
        $this->assertEquals($identifier, $server->getIdentifier());
        $this->assertEquals($domain, $server->getDomain());
        $this->assertEquals($protocol, $server->getProtocol());
    }
}

