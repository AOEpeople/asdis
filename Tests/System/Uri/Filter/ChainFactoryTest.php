<?php
namespace Aoe\Asdis\Tests\System\Uri\Filter;

use Aoe\Asdis\System\Configuration\Provider;
use Aoe\Asdis\System\Uri\Filter\Chain;
use Aoe\Asdis\System\Uri\Filter\ChainFactory;
use Aoe\Asdis\System\Uri\Filter\ContainsProtocol;
use Aoe\Asdis\System\Uri\Filter\WildcardProtocol;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

class ChainFactoryTest extends UnitTestCase
{
    /**
     * @var ChainFactory
     */
    private $factory;

    /**
     * (non-PHPdoc)
     */
    protected function setUp(): void
    {
        $this->factory = new ChainFactory();
        parent::setUp();
    }

    /**
     * @test
     */
    public function buildChain()
    {
        global $asdisBaseDir;

        $declarations = [
            [
                'key'   => 'containsProtocol',
                'class' => '\Aoe\Asdis\System\Uri\Filter\ContainsProtocol',
                'file'  => $asdisBaseDir . 'Classes/System/Uri/Filter/ContainsProtocol.php'
            ],
            [
                'key'   => 'wildcardProtocol',
                'class' => '\Aoe\Asdis\System\Uri\Filter\WildcardProtocol',
                'file'  => $asdisBaseDir . 'Classes/System/Uri/Filter/WildcardProtocol.php'
            ]
        ];

        $conf = $this->getMockBuilder(Provider::class)->setMethods(['getFilterKeys'])->getMock();
        $conf->expects($this->once())->method('getFilterKeys')->will(
            $this->returnValue(['containsProtocol', 'wildcardProtocol']
        ));

        $factory = $this->getMockBuilder(ChainFactory::class)
            ->setMethods(['getDeclarations', 'buildObjectFromKey'])
            ->getMock();

        $map = [
            [
                '\Aoe\Asdis\System\Uri\Filter\Chain', 
                new Chain()
            ],
            [
                '\Aoe\Asdis\System\Uri\Filter\WildcardProtocol',
                new WildcardProtocol()
            ],
            [
                '\Aoe\Asdis\System\Uri\Filter\WildcardProtocol',
                new WildcardProtocol()
            ],
        ];

        $objectManagerMock = $this->getMockBuilder(ObjectManagerInterface::class)->getMock();
        $objectManagerMock
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap($map));

        $factory->injectObjectManager($objectManagerMock);
        $factory->injectConfigurationProvider($conf);
        $factory->expects($this->once())->method('getDeclarations')->will($this->returnValue($declarations));
        $factory->expects($this->exactly(2))->method('buildObjectFromKey')->will(
            $this->returnValue(new ContainsProtocol()
        ));
        $factory->buildChain();
    }
}

