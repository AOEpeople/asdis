<?php

namespace Aoe\Asdis\Tests\Content\Scraper;

use Aoe\Asdis\Content\Scraper\ChainFactory;
use Aoe\Asdis\System\Configuration\Provider;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ChainFactoryTest extends UnitTestCase
{
    public function testBuildChain(): void
    {
        global $asdisBaseDir;
        $configurationProvider = $this->getMockBuilder(Provider::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getScraperKeys'])
            ->getMock();
        $configurationProvider->expects($this->once())
            ->method('getScraperKeys')
            ->willReturn([]);

        $chainFactory = $this->getMockBuilder(ChainFactory::class)
            ->onlyMethods(['getScraperDeclarations'])
            ->getMock();
        $chainFactory->expects($this->once())
            ->method('getScraperDeclarations')
            ->willReturn([]);
        $chainFactory->injectConfigurationProvider($configurationProvider);

        $chainFactory->buildChain();
    }
}
