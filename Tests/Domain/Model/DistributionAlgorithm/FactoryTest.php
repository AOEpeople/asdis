<?php

namespace Aoe\Asdis\Tests\Domain\Model\DistributionAlgorithm;

use Aoe\Asdis\Domain\Model\DistributionAlgorithm\Factory;
use Aoe\Asdis\Domain\Model\DistributionAlgorithm\HashBasedGroups;
use Aoe\Asdis\Domain\Model\DistributionAlgorithm\RoundRobin;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class FactoryTest extends UnitTestCase
{
    public function testBuildDistributionAlgorithmFromKey()
    {
        global $asdisBaseDir;

        $declarations = [
            [
                'key' => 'hashBasedGroups',
                'class' => HashBasedGroups::class,
                'file' => $asdisBaseDir . 'Classes/Domain/Model/DistributionAlgorithm/HashBasedGroups.php',
            ],
            [
                'key' => 'roundRobin',
                'class' => RoundRobin::class,
                'file' => $asdisBaseDir . 'Classes/Domain/Model/DistributionAlgorithm/RoundRobin.php',
            ],
        ];
        //TODO? , [], '', true
        $factory = $this->getMockBuilder(Factory::class)->setMethods(['getDeclarations'])->getMock();
        $factory->expects($this->once())
            ->method('getDeclarations')
            ->will($this->returnValue($declarations));

        $algorithm = $factory->buildDistributionAlgorithmFromKey('hashBasedGroups');
        $this->assertSame(HashBasedGroups::class, get_class($algorithm));
    }
}
