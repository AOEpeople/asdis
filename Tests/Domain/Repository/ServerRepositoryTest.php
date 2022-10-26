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
        $page = new Page();
        $server = [
            'identifier' => uniqid(),
            'domain' => 'example.com',
            'protocol' => 'http',
        ];
        $servers = [$server];
        $config = $this->getMockBuilder(Provider::class)->getMock();
        $config
            ->method('getServerDefinitions')
            ->will($this->returnValue($servers));

        $this->serverRepository->injectConfigurationProvider($config);

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
