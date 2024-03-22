<?php

namespace Aoe\Asdis\Tests\System\Uri\Filter;

use Aoe\Asdis\System\Configuration\Provider;
use Aoe\Asdis\System\Uri\Filter\ChainFactory;
use Aoe\Asdis\System\Uri\Filter\ContainsProtocol;
use Aoe\Asdis\System\Uri\Filter\WildcardProtocol;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ChainFactoryTest extends UnitTestCase
{
    public function testBuildChain(): void
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
            ->onlyMethods(['getFilterKeys'])
            ->getMock();
        $conf->expects($this->once())
            ->method('getFilterKeys')
            ->willReturn(
                ['containsProtocol', 'wildcardProtocol']
            );

        $factory = $this->getMockBuilder(ChainFactory::class)
            ->onlyMethods(['getDeclarations', 'buildObjectFromKey'])
            ->getMock();

        $factory->injectConfigurationProvider($conf);
        $factory->expects($this->once())
            ->method('getDeclarations')
            ->willReturn($declarations);
        $factory->expects($this->exactly(2))
            ->method('buildObjectFromKey')
            ->willReturn(new ContainsProtocol());
        $factory->buildChain();
    }
}
