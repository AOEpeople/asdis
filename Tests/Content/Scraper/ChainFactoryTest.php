<?php

namespace Aoe\Asdis\Tests\Content\Scraper;

use Aoe\Asdis\Content\Scraper\ChainFactory;
use Aoe\Asdis\System\Configuration\Provider;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class ChainFactoryTest extends UnitTestCase
{
    public function testBuildChain()
    {
        global $asdisBaseDir;
        $configurationProvider = $this->getMockBuilder(Provider::class)
            ->disableOriginalConstructor()
            ->setMethods(['getScraperKeys'])
            ->getMock();
        $configurationProvider->expects($this->once())
            ->method('getScraperKeys')
            ->will($this->returnValue([]));

        $chainFactory = $this->getMockBuilder(ChainFactory::class)
            ->setMethods(['getScraperDeclarations'])
            ->getMock();
        $chainFactory->expects($this->once())
            ->method('getScraperDeclarations')
            ->will($this->returnValue([]));
        $chainFactory->injectConfigurationProvider($configurationProvider);

        $chainFactory->buildChain();
    }
}
