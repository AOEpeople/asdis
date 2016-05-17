<?php

/**
 * Tests class Tx_Asdis_Content_Scraper_ChainFactory.
 */
class Tx_Asdis_Content_Scraper_ChainFactoryTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @test
	 */
	public function buildChain() {
		global $asdisBaseDir;
		$configurationProvider = $this->getMock('Tx_Asdis_System_Configuration_Provider', array('getScraperKeys'));
		$configurationProvider->expects($this->once())->method('getScraperKeys')->will($this->returnValue(array()));
		$chainFactory = $this->getMock('Tx_Asdis_Content_Scraper_ChainFactory', array('getScraperDeclarations'));
		$chainFactory->expects($this->once())->method('getScraperDeclarations')->will($this->returnValue(array()));
		$chainFactory->injectConfigurationProvider($configurationProvider);

        $this->objectManagerMock->method('get')
            ->with('Tx_Asdis_Content_Scraper_Chain')
            ->willReturn(new Tx_Asdis_Content_Scraper_Chain());

        $chainFactory->injectObjectManager($this->objectManagerMock);
		$chainFactory->buildChain();
	}
}