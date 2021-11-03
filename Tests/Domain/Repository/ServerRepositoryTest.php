<?php
namespace Aoe\Asdis\Tests\Domain\Repository;

use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\Domain\Model\Server\Collection;
use Aoe\Asdis\Domain\Model\Server\Factory;
use Aoe\Asdis\Domain\Repository\ServerRepository;
use Aoe\Asdis\System\Configuration\Provider;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

class ServerRepositoryTest extends UnitTestCase
{
    /**
     * @var ServerRepository
     */
    private $serverRepository;
    /**
     * (non-PHPdoc)
     */
    protected function setUp(): void
    {
        $this->serverRepository = new ServerRepository();
    }

    /**
     * Tests Aoe\Asdis\Domain\Repository\ServerRepository->findAll()
     * @test
     */
    public function findAllByPage()
    {
        $objectManager = $this->getMockBuilder(ObjectManagerInterface::class)->getMock();
        $objectManager
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValue($this->getMockBuilder(Server::class)->getMock()));

        $this->serverRepository->injectObjectManager($objectManager);
        $page = new Page();
        $server = [
            'identifier' => uniqid(),
            'domain' => 'example.com',
        ];
        $servers = [$server];
        $config = $this->getMockBuilder(Provider::class)->getMock();
        $config
            ->expects($this->any())
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
