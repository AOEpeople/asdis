<?php

$asdisBaseDir = dirname(__FILE__) . '/../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/Content/Scraper/Chain.php';
require_once $asdisBaseDir . 'Classes/Content/Scraper/ChainFactory.php';
require_once $asdisBaseDir . 'Classes/Content/Scraper/Html/Image.php';
require_once $asdisBaseDir . 'Classes/Content/Scraper/Html/InputImage.php';
require_once $asdisBaseDir . 'Classes/System/Configuration/Provider.php';

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
		$chainFactory->injectObjectManager(t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager'));
		$chainFactory->buildChain();
	}
}

