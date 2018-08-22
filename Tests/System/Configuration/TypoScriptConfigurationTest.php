<?php

/**
 * Tx_Asdis_System_Configuration_TypoScriptConfiguration test case.
 */
class Tx_Asdis_System_Configuration_TypoScriptConfigurationTest extends Tx_Asdis_Tests_AbstractTestcase {
	/**
	 * @var Tx_Asdis_System_Configuration_TypoScriptConfiguration
	 */
	private $typoScriptConfiguration;
	/**
	 * (non-PHPdoc)
	 */
	protected function setUp() {
		$this->typoScriptConfiguration = $this->getMock('Tx_Asdis_System_Configuration_TypoScriptConfiguration',array('getTypoScriptConfigurationArray'));

	}
	/**
	 * Tests Tx_Asdis_System_Configuration_TypoScriptConfiguration->getSetting()
	 * @test
	 * @expectedException Tx_Asdis_System_Configuration_Exception_TypoScriptSettingNotExists
	 */
	public function getSetting() {
		$this->typoScriptConfiguration->getSetting('xy');
	}
	/**
	 * Tests Tx_Asdis_System_Configuration_TypoScriptConfiguration->getSetting()
	 * @test
	 */
	public function getSettingsWithConfig(){
		$config = array('logger.'=>array('severity'=>1));
		$this->typoScriptConfiguration->expects($this->any())->method('getTypoScriptConfigurationArray')->will($this->returnValue($config));
		$this->typoScriptConfiguration->getSetting('logger.severity');
	}
	/**
	 * Tests Tx_Asdis_System_Configuration_TypoScriptConfiguration->getSetting()
	 * @test
	 */
	public function getSettingsWithSubtypeConfig(){
		$config = array('logger.'=>array('severity.'=>array('bla'=>'blub')));
		$this->typoScriptConfiguration->expects($this->any())->method('getTypoScriptConfigurationArray')->will($this->returnValue($config));
		$this->typoScriptConfiguration->getSetting('logger.severity','',TRUE);
	}
	/**
	 * Tests Tx_Asdis_System_Configuration_TypoScriptConfiguration->getSetting()
	 * @test
	 * @expectedException Tx_Asdis_System_Configuration_Exception_InvalidTypoScriptSetting
	 */
	public function getSettingsWithInvalidConfig(){
		$config = array('logger.'=>array('severity'=>1));
		$this->typoScriptConfiguration->expects($this->any())->method('getTypoScriptConfigurationArray')->will($this->returnValue($config));
		$this->typoScriptConfiguration->getSetting('logger.severity','array');
	}
}

