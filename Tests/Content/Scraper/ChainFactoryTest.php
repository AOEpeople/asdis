<?php
namespace Aoe\Asdis\Tests\Content\Scraper;

use Aoe\Asdis\Content\Scraper\Chain;
use Aoe\Asdis\Content\Scraper\ChainFactory;
use Aoe\Asdis\Content\Scraper\Html\Image;
use Aoe\Asdis\Content\Scraper\Html\Script;
use Aoe\Asdis\Domain\Model\Asset\Collection;
use Aoe\Asdis\System\Configuration\Provider;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

class ChainFactoryTest extends UnitTestCase
{
    /**
     * @test
     */
    public function buildChain()
    {
        global $asdisBaseDir;
        $configurationProvider = $this->getMockBuilder(Provider::class)->setMethods(['getScraperKeys'])->getMock();
        $configurationProvider->expects($this->once())->method('getScraperKeys')->will($this->returnValue([]));
        
        $chainFactory = $this->getMockBuilder(ChainFactory::class)->setMethods(['getScraperDeclarations'])->getMock();
        $chainFactory->expects($this->once())->method('getScraperDeclarations')->will($this->returnValue([]));
        $chainFactory->injectConfigurationProvider($configurationProvider);

        $objectManagerMock = $this->getMockBuilder(ObjectManagerInterface::class)->getMock();
        $objectManagerMock->method('get')
            ->with(Chain::class)
            ->willReturn(new Chain());

        $chainFactory->injectObjectManager($objectManagerMock);
        $chainFactory->buildChain();
    }
}