<?php

$asdisBaseDir = dirname(__FILE__) . '/../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/Content/Replacement/Map.php';
require_once $asdisBaseDir . 'Classes/Content/Replacement/Processor.php';

/**
 * Tests class Tx_Asdis_Content_Replacement_Processor.
 */
class Tx_Asdis_Content_Replacement_ProcessorTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_Content_Replacement_Processor
	 */
	private $processor;

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->processor = new Tx_Asdis_Content_Replacement_Processor();

	}
	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$this->processor = NULL;
	}

	/**
	 * @test
	 */
	public function replace() {
		$content = '<script type="text/css" src="typo3temp/js_css_optimizer/js_css_optimizer808ed94db016bc2941aa4b6de7f281664e40509f_b11ce65960acc0970b4bd1b7dc2292c85b9d4b4e_bundled_cssFiles.css" /><script type="text/css" src="/typo3temp/js_css_optimizer/_compressed_b8556e54a9173d519e2bf8851b6ec9778fc21495_js_css_optimizer3e8d68f9771f88ee7239129f8ffb85eb0e257769_e720b5b16198fa7190b9c5d8d49e717a98e79a7e_bundled_cssFiles.css" />';
		$result  = '<script type="text/css" src="http://media9.dev.myproject.com/typo3temp/js_css_optimizer/js_css_optimizer808ed94db016bc2941aa4b6de7f281664e40509f_b11ce65960acc0970b4bd1b7dc2292c85b9d4b4e_bundled_cssFiles.css" /><script type="text/css" src="http://media4.dev.myproject.com/typo3temp/js_css_optimizer/_compressed_b8556e54a9173d519e2bf8851b6ec9778fc21495_js_css_optimizer3e8d68f9771f88ee7239129f8ffb85eb0e257769_e720b5b16198fa7190b9c5d8d49e717a98e79a7e_bundled_cssFiles.css" />';
		$source1 = '~/?typo3temp/js_css_optimizer/js_css_optimizer808ed94db016bc2941aa4b6de7f281664e40509f_b11ce65960acc0970b4bd1b7dc2292c85b9d4b4e_bundled_cssFiles\.css~is';
		$target1 = 'http://media9.dev.myproject.com/typo3temp/js_css_optimizer/js_css_optimizer808ed94db016bc2941aa4b6de7f281664e40509f_b11ce65960acc0970b4bd1b7dc2292c85b9d4b4e_bundled_cssFiles.css';
		$source2 = '~/?typo3temp/js_css_optimizer/_compressed_b8556e54a9173d519e2bf8851b6ec9778fc21495_js_css_optimizer3e8d68f9771f88ee7239129f8ffb85eb0e257769_e720b5b16198fa7190b9c5d8d49e717a98e79a7e_bundled_cssFiles\.css~is';
		$target2 = 'http://media4.dev.myproject.com/typo3temp/js_css_optimizer/_compressed_b8556e54a9173d519e2bf8851b6ec9778fc21495_js_css_optimizer3e8d68f9771f88ee7239129f8ffb85eb0e257769_e720b5b16198fa7190b9c5d8d49e717a98e79a7e_bundled_cssFiles.css';
		$map = new Tx_Asdis_Content_Replacement_Map();
		$map->addMapping($source1, $target1);
		$map->addMapping($source2, $target2);
		$this->assertEquals($result, $this->processor->replace($map, $content));
	}
}

