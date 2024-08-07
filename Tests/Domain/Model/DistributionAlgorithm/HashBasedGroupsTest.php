<?php

namespace Aoe\Asdis\Tests\Domain\Model\DistributionAlgorithm;

use Aoe\Asdis\Domain\Model\Asset;
use Aoe\Asdis\Domain\Model\Asset\Collection as AssetCollection;
use Aoe\Asdis\Domain\Model\DistributionAlgorithm\HashBasedGroups;
use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\Domain\Model\Server\Collection as ServerCollection;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class HashBasedGroupsTest extends UnitTestCase
{
    private HashBasedGroups $algorithm;

    protected function setUp(): void
    {
        parent::setUp();

        $this->algorithm = new HashBasedGroups();
    }

    public function testDistribute(): void
    {
        $assets = new AssetCollection();
        $asset1 = new Asset();
        $asset2 = new Asset();
        $asset3 = new Asset();

        $asset1->setOriginalPath('/typo3temp/1.gif');
        $asset2->setOriginalPath('/typo3temp/2.gif');
        $asset3->setOriginalPath('/typo3temp/3.gif');

        $assets->append($asset1);
        $assets->append($asset2);
        $assets->append($asset3);

        $servers = new ServerCollection();
        $server1 = new Server();
        $server2 = new Server();

        $servers->append($server1);
        $servers->append($server2);

        $this->algorithm->distribute($assets, $servers);

        $this->assertSame(Server::class, $asset1->getServer() !== null ? $asset1->getServer()::class : self::class);
        $this->assertSame(Server::class, $asset2->getServer() !== null ? $asset2->getServer()::class : self::class);
        $this->assertSame(Server::class, $asset3->getServer() !== null ? $asset3->getServer()::class : self::class);
    }
}
