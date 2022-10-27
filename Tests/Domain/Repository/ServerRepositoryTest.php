<?php

namespace Aoe\Asdis\Tests\Domain\Repository;

use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\Domain\Model\Server\Collection;
use Aoe\Asdis\Domain\Model\Server\Factory;
use Aoe\Asdis\Domain\Repository\ServerRepository;
use Aoe\Asdis\System\Configuration\Provider;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class ServerRepositoryTest extends UnitTestCase
{
    private ServerRepository $serverRepository;

    protected function setUp(): void
    {
        $this->serverRepository = new ServerRepository();
    }

    /**
     * Tests Aoe\Asdis\Domain\Repository\ServerRepository->findAll()
     */
    public function testFindAllByPage()
    {
        $server = [
            'identifier' => uniqid(),
            'domain' => 'example.com',
            'protocol' => 'http',
        ];

        $servers = [$server];
        $providerMock = $this->getMockBuilder(Provider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $providerMock
            ->method('getServerDefinitions')
            ->will($this->returnValue($servers));

        $page = new Page($providerMock);

        $this->serverRepository->injectConfigurationProvider($providerMock);

        $factory = $this->getMockBuilder(Factory::class)->getMock();
        $factory
            ->expects($this->once())
            ->method('createServer')
            ->will($this->returnValue($this->getMockBuilder(Server::class)->getMock()));

        $this->serverRepository->injectServerFactory($factory);
        $test = $this->serverRepository->findAllByPage($page);

        $this->assertTrue($test instanceof Collection);
    }
}
