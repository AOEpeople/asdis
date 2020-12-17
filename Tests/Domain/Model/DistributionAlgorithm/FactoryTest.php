<?php
namespace Aoe\Asdis\Tests\Domain\Model\DistributionAlgorithm;

use Aoe\Asdis\Domain\Model\DistributionAlgorithm\Factory;
use Aoe\Asdis\Domain\Model\DistributionAlgorithm\HashBasedGroups;
use Aoe\Asdis\Domain\Model\DistributionAlgorithm\RoundRobin;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

class FactoryTest extends UnitTestCase
{
    /**
     * @test
     */
    public function buildDistributionAlgorithmFromKey()
    {
        global $asdisBaseDir;

        $declarations = [
            [
                'key'   => 'hashBasedGroups',
                'class' => 'Aoe\Asdis\Domain\Model\DistributionAlgorithm\HashBasedGroups',
                'file'  => $asdisBaseDir . 'Classes/Domain/Model/DistributionAlgorithm/HashBasedGroups.php'
            ],
            [
                'key'   => 'roundRobin',
                'class' => 'Aoe\Asdis\Domain\Model\DistributionAlgorithm\RoundRobin',
                'file'  => $asdisBaseDir . 'Classes/Domain/Model/DistributionAlgorithm/RoundRobin.php'
            ]
        ];
//TODO? , [], '', true
        $factory = $this->getMockBuilder(Factory::class)->setMethods(['getDeclarations'])->getMock();
        $factory->expects($this->once())->method('getDeclarations')->will($this->returnValue($declarations));

        $objectManagerMock = $this->getMockBuilder(ObjectManagerInterface::class)->getMock();
        $objectManagerMock->method('get')
            ->with(HashBasedGroups::class)
            ->willReturn(new HashBasedGroups());

        $factory->injectObjectManager($objectManagerMock);

        $algorithm = $factory->buildDistributionAlgorithmFromKey('hashBasedGroups');
        $this->assertEquals(HashBasedGroups::class, get_class($algorithm));
    }
}

