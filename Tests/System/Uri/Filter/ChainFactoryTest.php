<?php

namespace Aoe\Asdis\Tests\System\Uri\Filter;

use Aoe\Asdis\System\Configuration\Provider;
use Aoe\Asdis\System\Uri\Filter\ChainFactory;
use Aoe\Asdis\System\Uri\Filter\ContainsProtocol;
use Aoe\Asdis\System\Uri\Filter\WildcardProtocol;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class ChainFactoryTest extends UnitTestCase
{
    public function testBuildChain()
    {
        global $asdisBaseDir;

        $declarations = [
            [
                'key' => 'containsProtocol',
                'class' => ContainsProtocol::class,
                'file' => $asdisBaseDir . 'Classes/System/Uri/Filter/ContainsProtocol.php',
            ],
            [
                'key' => 'wildcardProtocol',
                'class' => WildcardProtocol::class,
                'file' => $asdisBaseDir . 'Classes/System/Uri/Filter/WildcardProtocol.php',
            ],
        ];

        $conf = $this->getMockBuilder(Provider::class)
            ->disableOriginalConstructor()
            ->setMethods(['getFilterKeys'])
            ->getMock();
        $conf->expects($this->once())
            ->method('getFilterKeys')
            ->will(
                $this->returnValue(
                    ['containsProtocol', 'wildcardProtocol']
                )
            );

        $factory = $this->getMockBuilder(ChainFactory::class)
            ->setMethods(['getDeclarations', 'buildObjectFromKey'])
            ->getMock();

        $factory->injectConfigurationProvider($conf);
        $factory->expects($this->once())
            ->method('getDeclarations')
            ->will($this->returnValue($declarations));
        $factory->expects($this->exactly(2))
            ->method('buildObjectFromKey')
            ->will($this->returnValue(new ContainsProtocol()));
        $factory->buildChain();
    }
}
