<?php
/**
 * @package    asdis
 * @subpackage Tests
 */
$asdisBaseDir = dirname(__FILE__) . '/../../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/System/Uri/Filter/Chain.php';
require_once $asdisBaseDir . 'Classes/System/Uri/Filter/ChainFactory.php';
require_once $asdisBaseDir . 'Classes/System/Uri/Filter/ContainsProtocol.php';
require_once $asdisBaseDir . 'Classes/System/Uri/Filter/WildcardProtocol.php';
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
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->factory = new Tx_Asdis_System_Uri_Filter_ChainFactory();
	}

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$this->factory = NULL;
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
		$factory->injectObjectManager(t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager'));
		$factory->injectConfigurationProvider($conf);
		$factory->expects($this->once())->method('getDeclarations')->will($this->returnValue($declarations));
		$factory->expects($this->exactly(2))->method('buildObjectFromKey')->will($this->returnValue(new Tx_Asdis_System_Uri_Filter_ContainsProtocol()));
		$factory->buildChain();
	}
}

