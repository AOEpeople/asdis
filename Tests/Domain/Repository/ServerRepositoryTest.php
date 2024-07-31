<?php

namespace Aoe\Asdis\Tests\Domain\Repository;

use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\Domain\Model\Server\Factory;
use Aoe\Asdis\Domain\Repository\ServerRepository;
use Aoe\Asdis\System\Configuration\Provider;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ServerRepositoryTest extends UnitTestCase
{
    private ServerRepository $serverRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serverRepository = new ServerRepository();
    }

    /**
     * Tests Aoe\Asdis\Domain\Repository\ServerRepository->findAll()
     */
    public function testFindAllByPage(): void
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
            ->willReturn($servers);

        $page = new Page($providerMock);

        $this->serverRepository->injectConfigurationProvider($providerMock);

        $factory = $this->getMockBuilder(Factory::class)->getMock();
        $factory
            ->expects($this->once())
            ->method('createServer')
            ->willReturn($this->getMockBuilder(Server::class)->getMock());

        $this->serverRepository->injectServerFactory($factory);
        $test = $this->serverRepository->findAllByPage($page);

        $this->assertInstanceOf(\Aoe\Asdis\Domain\Model\Server\Collection::class, $test);
    }
}
