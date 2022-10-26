<?php

namespace Aoe\Asdis\Tests\Domain\Model\DistributionAlgorithm;

use Aoe\Asdis\Domain\Model\Asset;
use Aoe\Asdis\Domain\Model\Asset\Collection as AssetCollection;
use Aoe\Asdis\Domain\Model\DistributionAlgorithm\RoundRobin;
use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\Domain\Model\Server\Collection as ServerCollection;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class RoundRobinTest extends UnitTestCase
{
    private RoundRobin $algorithm;

    protected function setUp(): void
    {
        $this->algorithm = new RoundRobin();
    }

    public function testDistribute()
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

        $server1->setIdentifier('m1');
        $server2->setIdentifier('m2');

        $servers->append($server1);
        $servers->append($server2);

        $this->algorithm->distribute($assets, $servers);

        $this->assertSame('m1', $asset1->getServer()->getIdentifier());
        $this->assertSame('m2', $asset2->getServer()->getIdentifier());
        $this->assertSame('m1', $asset3->getServer()->getIdentifier());
    }
}
