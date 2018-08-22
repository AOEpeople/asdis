<?php

/**
 * Tx_Asdis_System_Uri_Filter_ChainFactory test case.
 */
class Tx_Asdis_System_Uri_Filter_ChainFactoryTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_System_Uri_Filter_ChainFactory
	 */
	private $factory;

	/**
	 * (non-PHPdoc)
	 */
	protected function setUp() {
		$this->factory = new Tx_Asdis_System_Uri_Filter_ChainFactory();
        parent::setUp();
	}

	/**
	 * @test
	 */
	public function buildChain() {
		global $asdisBaseDir;
		$declarations = array(
			array(
				'key'   => 'containsProtocol',
				'class' => 'Tx_Asdis_System_Uri_Filter_ContainsProtocol',
				'file'  => $asdisBaseDir . 'Classes/System/Uri/Filter/ContainsProtocol.php'
			),
			array(
				'key'   => 'wildcardProtocol',
				'class' => 'Tx_Asdis_System_Uri_Filter_WildcardProtocol',
				'file'  => $asdisBaseDir . 'Classes/System/Uri/Filter/WildcardProtocol.php'
			)
		);
		$conf = $this->getMock('Tx_Asdis_System_Configuration_Provider', array('getFilterKeys'));
		$conf->expects($this->once())->method('getFilterKeys')->will($this->returnValue(array('containsProtocol', 'wildcardProtocol')));
		$factory = $this->getMock('Tx_Asdis_System_Uri_Filter_ChainFactory', array('getDeclarations', 'buildObjectFromKey'));

        $map = array(
            array('Tx_Asdis_System_Uri_Filter_Chain', new Tx_Asdis_System_Uri_Filter_Chain()),
            array('Tx_Asdis_System_Uri_Filter_WildcardProtocol', new Tx_Asdis_System_Uri_Filter_WildcardProtocol()),
            array('Tx_Asdis_System_Uri_Filter_WildcardProtocol', new Tx_Asdis_System_Uri_Filter_WildcardProtocol()),
        );

        $this->objectManagerMock->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap($map));

		$factory->injectObjectManager($this->objectManagerMock);
		$factory->injectConfigurationProvider($conf);
		$factory->expects($this->once())->method('getDeclarations')->will($this->returnValue($declarations));
		$factory->expects($this->exactly(2))->method('buildObjectFromKey')->will($this->returnValue(new Tx_Asdis_System_Uri_Filter_ContainsProtocol()));
		$factory->buildChain();
	}
}

